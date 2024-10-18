<?php
declare(strict_types=1);

namespace App\Application\Infrastructure\Repository;

use App\Application\Domain\Entity\Beer;
use App\Application\Domain\Repository\BeerRepositoryInterface;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepositoryProxy;
use Doctrine\Persistence\ManagerRegistry;


class BeerRepository extends ServiceEntityRepositoryProxy implements BeerRepositoryInterface {

	public function __construct(ManagerRegistry $registry) {
		parent::__construct($registry, Beer::class);
	}

	/**
	 * @param Beer $entity
	 *
	 * @return void
	 * @throws \Exception
	 */
	public function save(Beer $entity): void {
		try {
			$this->getEntityManager()->persist($entity);
			$this->getEntityManager()->flush();
		} catch (\Throwable $e) {
			$this->getEntityManager()->rollback();
			throw new \Exception($e->getMessage());
		}
	}

	// /**
	//  * @return Beer[] Returns an array of Beer objects
	//  */
	/*
	public function findByExampleField($value)
	{
		return $this->createQueryBuilder('b')
			->andWhere('b.exampleField = :val')
			->setParameter('val', $value)
			->orderBy('b.id', 'ASC')
			->setMaxResults(10)
			->getQuery()
			->getResult()
		;
	}
	*/

	/*
	public function findOneBySomeField($value): ?Beer
	{
		return $this->createQueryBuilder('b')
			->andWhere('b.exampleField = :val')
			->setParameter('val', $value)
			->getQuery()
			->getOneOrNullResult()
		;
	}
	*/
	public function findById($id): ?Beer {
		return $this->find($id);
	}


	public function findOneByCriteria(array $criteria, array $orderBy = NULL): ?Beer {
		return $this->findOneBy($criteria, $orderBy);
	}

	public function getAll(): array {
		return $this->findAll();
	}

	public function findByCriteria(array $criteria, array $orderBy = NULL, $limit = NULL, $offset = NULL): array {
		return $this->findBy($criteria, $orderBy, $limit, $offset);
	}


}
