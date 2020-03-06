<?php

namespace App\Repository;

use App\Entity\Strategy;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method Strategy|null find($id, $lockMode = null, $lockVersion = null)
 * @method Strategy|null findOneBy(array $criteria, array $orderBy = null)
 * @method Strategy[]    findAll()
 * @method Strategy[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class StrategyRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Strategy::class);
    }

    // /**
    //  * @return Strategy[] Returns an array of Strategy objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('s')
            ->andWhere('s.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('s.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Strategy
    {
        return $this->createQueryBuilder('s')
            ->andWhere('s.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
