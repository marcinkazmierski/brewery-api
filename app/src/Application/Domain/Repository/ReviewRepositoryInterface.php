<?php


namespace App\Application\Domain\Repository;


use App\Application\Domain\Entity\Review;

interface ReviewRepositoryInterface
{
    /**
     * @param $id
     * @param null $lockMode
     * @param null $lockVersion
     * @return Review|null
     */
    public function find($id, $lockMode = null, $lockVersion = null);

    /**
     * @param array $criteria
     * @param array|null $orderBy
     * @return Review|null
     */
    public function findOneBy(array $criteria, array $orderBy = null);

    /**
     * @return Review[]
     */
    public function findAll();

    /**
     * @param array $criteria
     * @param array|null $orderBy
     * @param null $limit
     * @param null $offset
     * @return Review[]
     */
    public function findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null);

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