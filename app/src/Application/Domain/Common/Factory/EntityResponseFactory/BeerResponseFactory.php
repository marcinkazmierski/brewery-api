<?php
declare(strict_types=1);

namespace App\Application\Domain\Common\Factory\EntityResponseFactory;

use App\Application\Domain\Common\Constants\UserBeerStatusConstants;
use App\Application\Domain\Common\Mapper\ResponseFieldMapper;
use App\Application\Domain\Entity\Beer;
use App\Application\Domain\Entity\Review;
use App\Application\Domain\Entity\User;
use App\Application\Domain\Repository\ReviewRepositoryInterface;

class BeerResponseFactory
{
    /** @var ReviewResponseFactory */
    protected ReviewResponseFactory $reviewResponseFactory;

    /** @var ReviewRepositoryInterface */
    protected ReviewRepositoryInterface $reviewRepository;

    /**
     * @param ReviewResponseFactory $reviewResponseFactory
     * @param ReviewRepositoryInterface $reviewRepository
     */
    public function __construct(ReviewResponseFactory $reviewResponseFactory, ReviewRepositoryInterface $reviewRepository)
    {
        $this->reviewResponseFactory = $reviewResponseFactory;
        $this->reviewRepository = $reviewRepository;
    }

    /**
     * @param Beer $entity
     * @param User $owner
     * @return array
     */
    public function create(Beer $entity, User $owner): array
    {
        $reviews = [];
        $ratingSum = 0;
        foreach ($entity->getReviews() as $review) {
            $ratingSum += $review->getRating();
            $reviews[] = $this->reviewResponseFactory->create($review);
        }

        $rating = 0;
        if ($entity->getReviews()->count() > 0) {
            $rating = round($ratingSum / $entity->getReviews()->count(), 2);
        }

        /** @var Review $review */
        $userReview = $this->reviewRepository->findOneBy(['owner' => $owner, 'beer' => $entity]);

        $status = UserBeerStatusConstants::DISABLED;
        if ($owner->getUnlockedBeers()->contains($entity)) {
            $status = UserBeerStatusConstants::UNLOCKED;
        }

        return [
            ResponseFieldMapper::BEER_ID => $entity->getId(),
            ResponseFieldMapper::BEER_NAME => $entity->getName(),
            ResponseFieldMapper::BEER_TITLE => $entity->getTitle(),
            ResponseFieldMapper::BEER_BACKGROUND_IMAGE => $entity->getBackgroundImage(),
            ResponseFieldMapper::BEER_CREATED_AT => $entity->getCreatedAt()->format('H:i d-m-Y'),
            ResponseFieldMapper::BEER_DESCRIPTION => $entity->getDescription(),
            ResponseFieldMapper::BEER_HOPS => $entity->getHops(),
            ResponseFieldMapper::BEER_ICON => $entity->getIcon(),
            ResponseFieldMapper::BEER_MALTS => $entity->getMalts(),
            ResponseFieldMapper::BEER_TAGS => $entity->getTags(),
            ResponseFieldMapper::BEER_REVIEWS => $reviews,
            ResponseFieldMapper::USER_BEER_REVIEW => $userReview ? $this->reviewResponseFactory->create($userReview) : null,
            ResponseFieldMapper::BEER_STATUS => $status,
            ResponseFieldMapper::BEER_RATING => $rating,
        ];
    }
}