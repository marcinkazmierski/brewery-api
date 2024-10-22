<?php


namespace App\Application\Domain\Repository;


use App\Application\Domain\Entity\User;
use App\Application\Domain\Entity\UserToken;

interface UserTokenRepositoryInterface
{

	/**
	 * @param $id
	 *
	 * @return \App\Application\Domain\Entity\UserToken|null
	 */
    public function findById($id ): ?UserToken;

    /**
     * @param array $criteria
     * @param array|null $orderBy
     * @return UserToken|null
     */
    public function findOneByCriteria(array $criteria, array $orderBy = null): ?UserToken;

    /**
     * @return UserToken[]
     */
    public function getAll(): array;

    /**
     * @param array $criteria
     * @param array|null $orderBy
     * @param null $limit
     * @param null $offset
     * @return UserToken[]
     */
    public function findByCriteria(array $criteria, array $orderBy = null, $limit = null, $offset = null): array;

    /**
     * @param string $tokenKey
     * @return UserToken
     * @throws \Exception
     */
    public function getTokenByTokenKey(string $tokenKey): UserToken;

    /**
     * @param User $user
     * @param string $appVersion
     * @return UserToken
     * @throws \Exception
     */
    public function generateToken(User $user, string $appVersion): UserToken;
}