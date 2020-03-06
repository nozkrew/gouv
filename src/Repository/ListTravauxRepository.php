<?php

namespace App\Repository;

use App\Entity\ListTravaux;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method ListTravaux|null find($id, $lockMode = null, $lockVersion = null)
 * @method ListTravaux|null findOneBy(array $criteria, array $orderBy = null)
 * @method ListTravaux[]    findAll()
 * @method ListTravaux[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ListTravauxRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ListTravaux::class);
    }

    // /**
    //  * @return ListTravaux[] Returns an array of ListTravaux objects
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
    public function findOneBySomeField($value): ?ListTravaux
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
