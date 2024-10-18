<?php


namespace App\Application\Domain\Repository;


use App\Application\Domain\Entity\Review;

interface ReviewRepositoryInterface
{

	/**
	 * @param $id
	 *
	 * @return \App\Application\Domain\Entity\Review|null
	 */
    public function findById($id): ?Review;

    /**
     * @param array $criteria
     * @param array|null $orderBy
     * @return Review|null
     */
    public function findOneByCriteria(array $criteria, array $orderBy = null): ?Review;

    /**
     * @return Review[]
     */
    public function getAll(): array;

    /**
     * @param array $criteria
     * @param array|null $orderBy
     * @param null $limit
     * @param null $offset
     * @return Review[]
     */
    public function findByCriteria(array $criteria, array $orderBy = null, $limit = null, $offset = null): array;

    /**
     * @param Review $entity
     * @throws \Exception
     */
    public function save(Review $entity): void;

    /**
     * @param Review $entity
     * @throws \Exception
     */
    public function remove(Review $entity): void;
}