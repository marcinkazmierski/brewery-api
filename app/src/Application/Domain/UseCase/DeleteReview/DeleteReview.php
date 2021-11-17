<?php
declare(strict_types=1);

namespace App\Application\Domain\UseCase\DeleteReview;

use App\Application\Domain\Common\Factory\ErrorResponseFactory\ErrorResponseFromExceptionFactoryInterface;
use App\Application\Domain\Exception\ValidateException;
use App\Application\Domain\Repository\ReviewRepositoryInterface;

/**
 * Class DeleteReview
 * @package App\Application\Domain\UseCase\DeleteReview
 */
class DeleteReview
{
    /** @var ReviewRepositoryInterface */
    private ReviewRepositoryInterface $reviewRepository;

    /** @var ErrorResponseFromExceptionFactoryInterface */
    private ErrorResponseFromExceptionFactoryInterface $errorResponseFromExceptionFactory;

    /**
     * DeleteReview constructor.
     * @param ReviewRepositoryInterface $reviewRepository
     * @param ErrorResponseFromExceptionFactoryInterface $errorResponseFromExceptionFactory
     */
    public function __construct(ReviewRepositoryInterface $reviewRepository, ErrorResponseFromExceptionFactoryInterface $errorResponseFromExceptionFactory)
    {
        $this->reviewRepository = $reviewRepository;
        $this->errorResponseFromExceptionFactory = $errorResponseFromExceptionFactory;
    }

    /**
     * @param DeleteReviewRequest $request
     * @param DeleteReviewPresenterInterface $presenter
     */
    public function execute(
        DeleteReviewRequest            $request,
        DeleteReviewPresenterInterface $presenter)
    {
        $response = new DeleteReviewResponse();
        try {
            $review = $this->reviewRepository->find($request->getReviewId());
            if (!$review) {
                throw new ValidateException("Review not exist");
            }
            if ($review->getOwner()->getId() !== $request->getUser()->getId()) {
                throw new ValidateException("Invalid owner");
            }
            $response->setOwner($review->getOwner());
            $response->setBeer($review->getBeer());

            $this->reviewRepository->remove($review);
        } catch (\Throwable $e) {
            $error = $this->errorResponseFromExceptionFactory->create($e);
            $response->setError($error);
        }
        $presenter->present($response);
    }
}
