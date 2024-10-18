<?php


namespace App\Application\Domain\Repository;


use App\Application\Domain\Entity\User;

interface UserRepositoryInterface
{

	/**
	 * @param $id
	 *
	 * @return \App\Application\Domain\Entity\User|null
	 */
    public function findById($id): ?User;

    /**
     * @param array $criteria
     * @param array|null $orderBy
     * @return User|null
     */
    public function findOneByCriteria(array $criteria, array $orderBy = null): ?User;

    /**
     * @return User[]
     */
    public function getAll(): array;

    /**
     * @param array $criteria
     * @param array|null $orderBy
     * @param null $limit
     * @param null $offset
     * @return User[]
     */
    public function findByCriteria(array $criteria, array $orderBy = null, $limit = null, $offset = null): array;

    /**
     * @param string $email
     * @return User
     * @throws \Exception
     */
    public function getUserByEmail(string $email): User;

    /**
     * @param string $nick
     * @return User
     * @throws \Exception
     */
    public function getUserByNick(string $nick): User;

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