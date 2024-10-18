<?php

namespace App\Application\Infrastructure\Repository;

use App\Application\Domain\Entity\User;
use App\Application\Domain\Entity\UserToken;
use App\Application\Domain\Repository\UserTokenRepositoryInterface;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepositoryProxy;
use Doctrine\Persistence\ManagerRegistry;

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
        $this->getEntityManager()->persist($token);
        $this->getEntityManager()->flush();
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
	public function findById($id): ?UserToken {
		return $this->find($id);
	}


	public function findOneByCriteria(array $criteria, array $orderBy = NULL): ?UserToken {
		return $this->findOneBy($criteria, $orderBy);
	}

	public function getAll(): array {
		return $this->findAll();
	}

	public function findByCriteria(array $criteria, array $orderBy = NULL, $limit = NULL, $offset = NULL): array {
		return $this->findBy($criteria, $orderBy, $limit, $offset);
	}
}
