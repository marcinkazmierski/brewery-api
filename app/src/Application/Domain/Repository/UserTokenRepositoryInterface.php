<?php


namespace App\Application\Domain\Repository;


use App\Application\Domain\Entity\User;
use App\Application\Domain\Entity\UserToken;

interface UserTokenRepositoryInterface
{
    /**
     * @param $id
     * @param null $lockMode
     * @param null $lockVersion
     * @return UserToken|null
     */
    public function find($id, $lockMode = null, $lockVersion = null);

    /**
     * @param array $criteria
     * @param array|null $orderBy
     * @return UserToken|null
     */
    public function findOneBy(array $criteria, array $orderBy = null);

    /**
     * @return UserToken[]
     */
    public function findAll();

    /**
     * @param array $criteria
     * @param array|null $orderBy
     * @param null $limit
     * @param null $offset
     * @return UserToken[]
     */
    public function findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null);

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