<?php


namespace App\Application\Domain\Common\Factory\EntityResponseFactory;


use App\Application\Domain\Common\Mapper\ResponseFieldMapper;
use App\Application\Domain\Entity\Review;

class ReviewResponseFactory
{
    protected UserResponseFactory $userResponseFactory;

    /**
     * ReviewResponseFactory constructor.
     * @param UserResponseFactory $userResponseFactory
     */
    public function __construct(UserResponseFactory $userResponseFactory)
    {
        $this->userResponseFactory = $userResponseFactory;
    }

    /**
     * @param Review $entity
     * @return array
     */
    public function create(Review $entity): array
    {
        return [
            ResponseFieldMapper::REVIEW_ID => $entity->getId(),
            ResponseFieldMapper::REVIEW_TEXT => $entity->getText(),
            ResponseFieldMapper::REVIEW_RATING => $entity->getRating(),
            ResponseFieldMapper::REVIEW_CREATED_AT => $entity->getCreatedAt()->format('H:i d-m-Y'),
            ResponseFieldMapper::REVIEW_OWNER => $this->userResponseFactory->create($entity->getOwner()),
        ];
    }
}