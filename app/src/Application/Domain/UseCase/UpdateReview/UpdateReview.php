<?php
declare(strict_types=1);

namespace App\Application\Domain\UseCase\UpdateReview;

use App\Application\Domain\Common\Factory\ErrorResponseFactory\ErrorResponseFromExceptionFactoryInterface;
use App\Application\Domain\Exception\ValidateException;
use App\Application\Domain\Repository\ReviewRepositoryInterface;

/**
 * Class UpdateReview
 * @package App\Application\Domain\UseCase\UpdateReview
 */
class UpdateReview
{
    /** @var ReviewRepositoryInterface */
    private $reviewRepository;

    /** @var ErrorResponseFromExceptionFactoryInterface $errorResponseFromExceptionFactory */
    private $errorResponseFromExceptionFactory;

    /**
     * UpdateReview constructor.
     * @param ReviewRepositoryInterface $reviewRepository
     * @param ErrorResponseFromExceptionFactoryInterface $errorResponseFromExceptionFactory
     */
    public function __construct(ReviewRepositoryInterface $reviewRepository, ErrorResponseFromExceptionFactoryInterface $errorResponseFromExceptionFactory)
    {
        $this->reviewRepository = $reviewRepository;
        $this->errorResponseFromExceptionFactory = $errorResponseFromExceptionFactory;
    }


    /**
     * @param UpdateReviewRequest $request
     * @param UpdateReviewPresenterInterface $presenter
     */
    public function execute(
        UpdateReviewRequest $request,
        UpdateReviewPresenterInterface $presenter)
    {
        $response = new UpdateReviewResponse();
        try {
            $review = $this->reviewRepository->findById($request->getReviewId());
            if (!$review) {
                throw new ValidateException("Review not exist");
            }
            if ($review->getOwner()->getId() !== $request->getUser()->getId()) {
                throw new ValidateException("Invalid owner");
            }
            if (empty($request->getRating()) || $request->getRating() < 1 || $request->getRating() > 5) {
                throw new ValidateException("Invalid rating field");
            }
            $review->setText($request->getText());
            $review->setRating($request->getRating());
            $this->reviewRepository->save($review);
        } catch (\Throwable $e) {
            $error = $this->errorResponseFromExceptionFactory->create($e);
            $response->setError($error);
        }
        $presenter->present($response);
    }
}
