<?php
declare(strict_types=1);

namespace App\Application\Domain\UseCase\CreateReview;

use App\Application\Domain\Common\Factory\ErrorResponseFactory\ErrorResponseFromExceptionFactoryInterface;
use App\Application\Domain\Entity\Beer;
use App\Application\Domain\Entity\Review;
use App\Application\Domain\Exception\ValidateException;
use App\Application\Domain\Repository\BeerRepositoryInterface;
use App\Application\Domain\Repository\ReviewRepositoryInterface;

/**
 * Class CreateReview
 * @package App\Application\Domain\UseCase\CreateReview
 */
class CreateReview
{
    /** @var BeerRepositoryInterface */
    private BeerRepositoryInterface $beerRepository;

    /** @var ReviewRepositoryInterface */
    private ReviewRepositoryInterface $reviewRepository;

    /** @var ErrorResponseFromExceptionFactoryInterface $errorResponseFromExceptionFactory */
    private ErrorResponseFromExceptionFactoryInterface $errorResponseFromExceptionFactory;

    /**
     * CreateReview constructor.
     * @param BeerRepositoryInterface $beerRepository
     * @param ReviewRepositoryInterface $reviewRepository
     * @param ErrorResponseFromExceptionFactoryInterface $errorResponseFromExceptionFactory
     */
    public function __construct(BeerRepositoryInterface $beerRepository, ReviewRepositoryInterface $reviewRepository, ErrorResponseFromExceptionFactoryInterface $errorResponseFromExceptionFactory)
    {
        $this->beerRepository = $beerRepository;
        $this->reviewRepository = $reviewRepository;
        $this->errorResponseFromExceptionFactory = $errorResponseFromExceptionFactory;
    }


    /**
     * @param CreateReviewRequest $request
     * @param CreateReviewPresenterInterface $presenter
     */
    public function execute(
        CreateReviewRequest            $request,
        CreateReviewPresenterInterface $presenter)
    {
        $response = new CreateReviewResponse();
        try {
            if (empty($request->getRating()) || $request->getRating() < 1 || $request->getRating() > 5) {
                throw new ValidateException("Invalid rating field");
            }
            if (empty($request->getBeerId())) {
                throw new ValidateException("Empty beerId field");
            }

            /** @var Beer $beer */
            $beer = $this->beerRepository->find($request->getBeerId());
            if (empty($beer)) {
                throw new ValidateException("Invalid beerId");
            }
            if (!$request->getUser()->getUnlockedBeers()->contains($beer)) {
                throw new ValidateException("Beer locked for this user");
            }

            /** @var Review $review */
            $review = $this->reviewRepository->findOneBy(['owner' => $request->getUser(), 'beer' => $beer]);
            if (!empty($review)) {
                throw new ValidateException("Review exist!");
            }
            $review = new Review();
            $review->setRating($request->getRating());
            $review->setOwner($request->getUser());
            $review->setBeer($beer);
            $review->setText($request->getText());
            $this->reviewRepository->save($review);
            $response->setReview($review);
        } catch (\Throwable $e) {
            $error = $this->errorResponseFromExceptionFactory->create($e);
            $response->setError($error);
        }
        $presenter->present($response);
    }
}
