<?php
declare(strict_types=1);

namespace App\Application\Infrastructure\Repository;

use App\Application\Domain\Entity\Review;
use App\Application\Domain\Repository\ReviewRepositoryInterface;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepositoryProxy;
use Doctrine\Persistence\ManagerRegistry;

class ReviewRepository extends ServiceEntityRepositoryProxy implements ReviewRepositoryInterface {

	public function __construct(ManagerRegistry $registry) {
		parent::__construct($registry, Review::class);
	}

	/**
	 * @param Review $entity
	 *
	 * @throws \Exception
	 */
	public function save(Review $entity): void {
		try {
			$this->getEntityManager()->persist($entity);
			$this->getEntityManager()->flush();
		} catch (\Throwable $e) {
			$this->getEntityManager()->rollback();
			throw new \Exception($e->getMessage());
		}
	}


	/**
	 * @param Review $entity
	 *
	 * @throws \Exception
	 */
	public function remove(Review $entity): void {
		try {
			$this->getEntityManager()->remove($entity);
			$this->getEntityManager()->flush();
		} catch (\Throwable $e) {
			$this->getEntityManager()->rollback();
			throw new \Exception($e->getMessage());
		}
	}

	// /**
	//  * @return Review[] Returns an array of Review objects
	//  */
	/*
	public function findByExampleField($value)
	{
		return $this->createQueryBuilder('r')
			->andWhere('r.exampleField = :val')
			->setParameter('val', $value)
			->orderBy('r.id', 'ASC')
			->setMaxResults(10)
			->getQuery()
			->getResult()
		;
	}
	*/

	/*
	public function findOneBySomeField($value): ?Review
	{
		return $this->createQueryBuilder('r')
			->andWhere('r.exampleField = :val')
			->setParameter('val', $value)
			->getQuery()
			->getOneOrNullResult()
		;
	}
	*/
	public function findById($id): ?Review {
		return $this->find($id);
	}


	public function findOneByCriteria(array $criteria, array $orderBy = NULL): ?Review {
		return $this->findOneBy($criteria, $orderBy);
	}

	public function getAll(): array {
		return $this->findAll();
	}

	public function findByCriteria(array $criteria, array $orderBy = NULL, $limit = NULL, $offset = NULL): array {
		return $this->findBy($criteria, $orderBy, $limit, $offset);
	}

}
