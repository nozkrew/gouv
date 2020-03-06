<?php

namespace App\Repository;

use App\Entity\ListTypeBien;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method ListTypeBien|null find($id, $lockMode = null, $lockVersion = null)
 * @method ListTypeBien|null findOneBy(array $criteria, array $orderBy = null)
 * @method ListTypeBien[]    findAll()
 * @method ListTypeBien[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ListTypeBienRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ListTypeBien::class);
    }

    // /**
    //  * @return ListTypeBien[] Returns an array of ListTypeBien objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('l')
            ->andWhere('l.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('l.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?ListTypeBien
    {
        return $this->createQueryBuilder('l')
            ->andWhere('l.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
