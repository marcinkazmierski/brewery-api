<?php

namespace App\Controller;

use App\Application\Domain\Entity\Beer;
use App\Application\Domain\Entity\Review;
use App\Application\Domain\Entity\User;
use App\Application\Infrastructure\Repository\BeerRepository;
use App\Application\Infrastructure\Repository\ReviewRepository;
use App\Exceptions\ValidateException;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/api/review")
 *
 * Class ReviewController
 * @package App\Controller
 */
class ReviewController extends AbstractController
{
    /** @var ReviewRepository */
    private $reviewRepository;

    /** @var BeerRepository */
    private $beerRepository;

    /**
     * ReviewController constructor.
     * @param ReviewRepository $reviewRepository
     * @param BeerRepository $beerRepository
     */
    public function __construct(ReviewRepository $reviewRepository, BeerRepository $beerRepository)
    {
        $this->reviewRepository = $reviewRepository;
        $this->beerRepository = $beerRepository;
    }


    /**
     * @Route(
     *     "/add",
     *     methods={"POST"},
     *     name="add_new_review"
     * )
     * @return Response
     */
    public function add(Request $request): Response
    {
        try {
            /** @var User $currentUser */
            $currentUser = $this->getUser();

            $responseData = [];
            $content = json_decode($request->getContent(), true);
            $rating = (float)($content['rating'] ?? 0);
            $text = (string)($content['text'] ?? '');
            $beerCode = (string)($content['beer']['code'] ?? '');

            if (empty($rating) || $rating < 1 || $rating > 5) {
                throw new ValidateException("Invalid rating field");
            }
            if (empty($text)) {
                throw new ValidateException("Empty text field");
            }
            if (empty($beerCode)) {
                throw new ValidateException("Empty beer->code field");
            }

            /** @var Beer $beer */
            $beer = $this->beerRepository->findOneBy(['code' => $beerCode]);
            if (empty($beer)) {
                throw new ValidateException("Invalid beer code");
            }
            if (!$currentUser->getUnlockedBeers()->contains($beer)) {
                throw new ValidateException("Beer locked for this user");
            }

            /** @var Review $review */
            $review = $this->reviewRepository->findOneBy(['owner' => $currentUser, 'beer' => $beer]);
            if (!empty($review)) {
                throw new ValidateException("Review exist!");
            }
            $review = new Review();
            $review->setRating($rating);
            $review->setOwner($currentUser);
            $review->setBeer($beer);
            $review->setText($text);
            $this->getDoctrine()->getManager()->persist($review);
            $this->getDoctrine()->getManager()->flush();
            return new JsonResponse($responseData, JsonResponse::HTTP_OK);
        } catch (\Throwable $e) {
            return new JsonResponse(['message' => $e->getMessage()], JsonResponse::HTTP_BAD_REQUEST);
        }
    }
}
