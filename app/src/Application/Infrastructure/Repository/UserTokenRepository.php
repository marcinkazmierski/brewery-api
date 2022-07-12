<?php

namespace App\Application\Infrastructure\Repository;

use App\Application\Domain\Entity\User;
use App\Application\Domain\Entity\UserToken;
use App\Application\Domain\Repository\UserTokenRepositoryInterface;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method UserToken|null find($id, $lockMode = null, $lockVersion = null)
 * @method UserToken|null findOneBy(array $criteria, array $orderBy = null)
 * @method UserToken[]    findAll()
 * @method UserToken[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class UserTokenRepository extends ServiceEntityRepository implements UserTokenRepositoryInterface
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, UserToken::class);
    }

    /**
     * @param User $user
     * @param string $appVersion
     * @return UserToken
     * @throws \Exception
     */
    public function generateToken(User $user, string $appVersion): UserToken
    {
        $token = new UserToken();
        $token->setTokenKey(bin2hex(random_bytes(64)));
        $token->setUser($user);
        $token->setAppVersion($appVersion);
        $this->_em->persist($token);
        $this->_em->flush();
        return $token;
    }

    /**
     * @param string $tokenKey
     * @return UserToken
     * @throws \Exception
     */
    public function getTokenByTokenKey(string $tokenKey): UserToken
    {
        /** @var UserToken $token */
        $token = $this->findOneBy(['tokenKey' => $tokenKey]);
        if (!$token) {
            throw new \Exception('User token not found.');
        }
        return $token;
    }

    // /**
    //  * @return UserToken[] Returns an array of UserToken objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('u')
            ->andWhere('u.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('u.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?UserToken
    {
        return $this->createQueryBuilder('u')
            ->andWhere('u.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
