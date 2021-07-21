<?php


namespace App\Application\Domain\Common\Factory\EntityResponseFactory;


use App\Application\Domain\Common\Constants\UserBeerStatusConstants;
use App\Application\Domain\Common\Mapper\ResponseFieldMapper;
use App\Application\Domain\Entity\Beer;

class BeerResponseFactory
{
    protected ReviewResponseFactory $reviewResponseFactory;

    /**
     * BeerResponseFactory constructor.
     * @param ReviewResponseFactory $reviewResponseFactory
     */
    public function __construct(ReviewResponseFactory $reviewResponseFactory)
    {
        $this->reviewResponseFactory = $reviewResponseFactory;
    }


    /**
     * @param Beer $entity
     * @return array
     */
    public function create(Beer $entity): array
    {
        $reviews = [];
        foreach ($entity->getReviews() as $review) {
            $reviews[] = $this->reviewResponseFactory->create($review);
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
            ResponseFieldMapper::BEER_STATUS => UserBeerStatusConstants::DISABLED,
            ResponseFieldMapper::BEER_RATING => 4.45, //todo!!!
        ];
    }
}