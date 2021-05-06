<?php


namespace App\Application\Domain\Repository;


use App\Application\Domain\Entity\User;

interface UserRepositoryInterface
{
    /**
     * @param $id
     * @param null $lockMode
     * @param null $lockVersion
     * @return User|null
     */
    public function find($id, $lockMode = null, $lockVersion = null);

    /**
     * @param array $criteria
     * @param array|null $orderBy
     * @return User|null
     */
    public function findOneBy(array $criteria, array $orderBy = null);

    /**
     * @return User[]
     */
    public function findAll();

    /**
     * @param array $criteria
     * @param array|null $orderBy
     * @param null $limit
     * @param null $offset
     * @return User[]
     */
    public function findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null);

    /**
     * @param string $username
     * @return User|null;
     */
    public function loadUserByUsername(string $username);

    /**
     * @param string $email
     * @return User
     * @throws \Exception
     */
    public function getUserByEmail(string $email): User;

    /**
     * @param User $entity
     * @throws \Exception
     */
    public function save(User $entity): void;

    /**
     * @param string $email
     * @param string $password
     * @return User
     * @throws \Exception
     */
    public function getUserByEmailAndPassword(string $email, string $password): User;
}