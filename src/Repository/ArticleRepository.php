<?php

namespace App\Repository;

use App\Entity\Article;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;
use Doctrine\ORM\NonUniqueResultException;
use Exception;

/**
 * @method Article|null find($id, $lockMode = null, $lockVersion = null)
 * @method Article|null findOneBy(array $criteria, array $orderBy = null)
 * @method Article[]    findAll()
 * @method Article[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ArticleRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Article::class);
    }


	/**
	 * @param string $order
	 * @param int $page
	 * @param int $limit
	 * @return Article[] Returns an array of Article objects
	 */

    public function findAllWithOrderAndLimit($order = 'DESC', $page = 1, $limit = 5)
    {
        return $this->createQueryBuilder('a')
          //  ->andWhere('a.exampleField = :val')
          //  ->setParameter('val', $value)
            ->orderBy('a.id', $order)
	        ->setFirstResult($limit * ($page - 1))
            ->setMaxResults($limit)
            ->getQuery()
            ->getResult()
        ;
    }

	/**
	 * @return array|NonUniqueResultException|Exception
	 */
	public function getCount()
	{
		$entityManager = $this->getEntityManager();
		$queryBuilder = $entityManager->createQueryBuilder();
		$queryBuilder
			->select('count(a)')
			->from('App:Article', 'a');

		try {
			return $queryBuilder->getQuery()->getSingleScalarResult();
		} catch (NonUniqueResultException $e) {
			return $e;
		}
	}



	/*
	public function findOneBySomeField($value): ?Article
	{
		return $this->createQueryBuilder('a')
			->andWhere('a.exampleField = :val')
			->setParameter('val', $value)
			->getQuery()
			->getOneOrNullResult()
		;
	}
	*/
}
