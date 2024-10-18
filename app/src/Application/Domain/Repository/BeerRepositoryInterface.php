<?php


namespace App\Application\Domain\Repository;


use App\Application\Domain\Entity\Beer;

interface BeerRepositoryInterface
{

	/**
	 * @param $id
	 *
	 * @return \App\Application\Domain\Entity\Beer|null
	 */
    public function findById($id): ?Beer;

    /**
     * @param array $criteria
     * @param array|null $orderBy
     * @return Beer|null
     */
    public function findOneByCriteria(array $criteria, array $orderBy = null): ?Beer;

    /**
     * @return Beer[]
     */
    public function getAll(): array;

    /**
     * @param array $criteria
     * @param array|null $orderBy
     * @param null $limit
     * @param null $offset
     * @return Beer[]
     */
    public function findByCriteria(array $criteria, array $orderBy = null, $limit = null, $offset = null): array;

    /**
     * @param Beer $entity
     * @throws \Exception
     */
    public function save(Beer $entity): void;
}