<?php


namespace App\Application\Domain\Repository;


use App\Application\Domain\Entity\Beer;

interface BeerRepositoryInterface
{
    /**
     * @param $id
     * @param null $lockMode
     * @param null $lockVersion
     * @return Beer|null
     */
    public function find($id, $lockMode = null, $lockVersion = null);

    /**
     * @param array $criteria
     * @param array|null $orderBy
     * @return Beer|null
     */
    public function findOneBy(array $criteria, array $orderBy = null);

    /**
     * @return Beer[]
     */
    public function findAll();

    /**
     * @param array $criteria
     * @param array|null $orderBy
     * @param null $limit
     * @param null $offset
     * @return Beer[]
     */
    public function findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null);
}