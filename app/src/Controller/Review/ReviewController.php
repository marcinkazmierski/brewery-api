<?php

namespace App\Controller\Review;

use App\Application\Domain\Common\Mapper\RequestFieldMapper;
use App\Application\Domain\Entity\Beer;
use App\Application\Domain\Entity\Review;
use App\Application\Domain\Entity\User;
use App\Application\Domain\UseCase\CreateReview\CreateReview;
use App\Application\Domain\UseCase\CreateReview\CreateReviewPresenterInterface;
use App\Application\Domain\UseCase\CreateReview\CreateReviewRequest;
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
     * Create new review.
     *
     * @Route(
     *     "/add",
     *     methods={"POST"},
     *     name="add_new_review"
     * )
     * @param Request $request
     * @param CreateReview $useCase
     * @param CreateReviewPresenterInterface $presenter
     * @return Response
     */
    public function add(Request $request, CreateReview $useCase, CreateReviewPresenterInterface $presenter): Response
    {
        /** @var User $currentUser */
        $currentUser = $this->getUser();

        $content = json_decode($request->getContent(), true);
        $rating = (float)($content[RequestFieldMapper::REVIEW_RATING] ?? 0);
        $text = (string)($content[RequestFieldMapper::REVIEW_TEXT] ?? '');
        $beerId = (int)($content[RequestFieldMapper::BEER_ID] ?? 0);

        $authenticationRequest = new CreateReviewRequest($currentUser, $rating, $text, $beerId);
        $useCase->execute($authenticationRequest, $presenter);
        return $presenter->view();
    }
}
