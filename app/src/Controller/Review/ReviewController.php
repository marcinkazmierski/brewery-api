<?php

namespace App\Controller\Review;

use App\Application\Domain\Common\Mapper\RequestFieldMapper;
use App\Application\Domain\Entity\User;
use App\Application\Domain\UseCase\CreateReview\CreateReview;
use App\Application\Domain\UseCase\CreateReview\CreateReviewPresenterInterface;
use App\Application\Domain\UseCase\CreateReview\CreateReviewRequest;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use OpenApi\Annotations as OA;

/**
 * @Route("/api/review")
 *
 * Class ReviewController
 * @package App\Controller
 */
class ReviewController extends AbstractController
{
    /**
     * Create new review.
     * @OA\Post(
     *     path="/api/review/add",
     *     description="Create new review.",
     *     tags = {"Review"},
     *     @OA\Parameter(ref="#/components/parameters/X-AUTH-TOKEN"),
     *     @OA\RequestBody(
     *      required=true,
     *      @OA\JsonContent(
     *          type = "object",
     *          @OA\Property(property="reviewRating", ref="#/components/schemas/rating"),
     *          @OA\Property(property="reviewText", ref="#/components/schemas/text"),
     *          @OA\Property(property="beerId", ref="#/components/schemas/id")
     *      ),
     *     ),
     *     @OA\Response(response="201", ref="#/components/responses/noContent"),
     *     @OA\Response(response="400", ref="#/components/responses/badRequest"),
     *     @OA\Response(response="500", ref="#/components/responses/generalError"),
     * ),
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
