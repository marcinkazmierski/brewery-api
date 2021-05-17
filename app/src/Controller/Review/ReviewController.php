<?php

namespace App\Controller\Review;

use App\Application\Domain\Common\Mapper\RequestFieldMapper;
use App\Application\Domain\Entity\User;
use App\Application\Domain\UseCase\CreateReview\CreateReview;
use App\Application\Domain\UseCase\CreateReview\CreateReviewPresenterInterface;
use App\Application\Domain\UseCase\CreateReview\CreateReviewRequest;
use App\Application\Domain\UseCase\DeleteReview\DeleteReview;
use App\Application\Domain\UseCase\DeleteReview\DeleteReviewPresenterInterface;
use App\Application\Domain\UseCase\DeleteReview\DeleteReviewRequest;
use App\Application\Domain\UseCase\UpdateReview\UpdateReview;
use App\Application\Domain\UseCase\UpdateReview\UpdateReviewPresenterInterface;
use App\Application\Domain\UseCase\UpdateReview\UpdateReviewRequest;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use OpenApi\Annotations as OA;

/**
 * Class ReviewController
 * @package App\Controller
 */
#[Route('/api/review')]
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
     * @param Request $request
     * @param CreateReview $useCase
     * @param CreateReviewPresenterInterface $presenter
     * @return Response
     */
    #[Route('/add', name: 'add-new-review', methods: ['POST'])]
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

    /**
     * Update review.
     * @OA\Patch(
     *     path="/api/review/{reviewId}",
     *     description="Update review.",
     *     tags = {"Review"},
     *     @OA\Parameter(ref="#/components/parameters/X-AUTH-TOKEN"),
     *     @OA\RequestBody(
     *      required=true,
     *      @OA\JsonContent(
     *          type = "object",
     *          @OA\Property(property="reviewRating", ref="#/components/schemas/rating"),
     *          @OA\Property(property="reviewText", ref="#/components/schemas/text")
     *      ),
     *     ),
     *     @OA\Response(response="201", ref="#/components/responses/noContent"),
     *     @OA\Response(response="400", ref="#/components/responses/badRequest"),
     *     @OA\Response(response="500", ref="#/components/responses/generalError"),
     * ),
     * @param Request $request
     * @param int $reviewId
     * @param UpdateReview $useCase
     * @param UpdateReviewPresenterInterface $presenter
     * @return Response
     */
    #[Route('/{reviewId}', name: 'update-review', requirements: ['reviewId' => '\d+'], methods: ['PATCH'])]
    public function update(Request $request, int $reviewId, UpdateReview $useCase, UpdateReviewPresenterInterface $presenter): Response
    {
        /** @var User $currentUser */
        $currentUser = $this->getUser();

        $content = json_decode($request->getContent(), true);
        $rating = (float)($content[RequestFieldMapper::REVIEW_RATING] ?? 0);
        $text = (string)($content[RequestFieldMapper::REVIEW_TEXT] ?? '');

        $authenticationRequest = new UpdateReviewRequest($currentUser, $rating, $text, $reviewId);
        $useCase->execute($authenticationRequest, $presenter);
        return $presenter->view();
    }

    /**
     * Delete review.
     * @OA\Delete(
     *     path="/api/review/{reviewId}",
     *     description="Delete review.",
     *     tags = {"Review"},
     *     @OA\Parameter(ref="#/components/parameters/X-AUTH-TOKEN"),
     *     @OA\RequestBody(
     *      required=true,
     *      @OA\JsonContent(
     *          type = "object"
     *      ),
     *     ),
     *     @OA\Response(response="201", ref="#/components/responses/noContent"),
     *     @OA\Response(response="400", ref="#/components/responses/badRequest"),
     *     @OA\Response(response="500", ref="#/components/responses/generalError"),
     * ),
     * @param Request $request
     * @param int $reviewId
     * @param DeleteReview $useCase
     * @param DeleteReviewPresenterInterface $presenter
     * @return Response
     */
    #[Route('/{reviewId}', name: 'delete-review', requirements: ['reviewId' => '\d+'], methods: ['DELETE'])]
    public function delete(Request $request, int $reviewId, DeleteReview $useCase, DeleteReviewPresenterInterface $presenter): Response
    {
        /** @var User $currentUser */
        $currentUser = $this->getUser();

        $authenticationRequest = new DeleteReviewRequest($currentUser, $reviewId);
        $useCase->execute($authenticationRequest, $presenter);
        return $presenter->view();
    }
}
