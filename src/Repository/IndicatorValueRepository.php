<?php

namespace App\Repository;

use App\Entity\IndicatorValue;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method IndicatorValue|null find($id, $lockMode = null, $lockVersion = null)
 * @method IndicatorValue|null findOneBy(array $criteria, array $orderBy = null)
 * @method IndicatorValue[]    findAll()
 * @method IndicatorValue[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class IndicatorValueRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, IndicatorValue::class);
    }
    
    public function findByCityAndIndicator($city, $indicatorCode){
        $qb = $this->createQueryBuilder("c");
        $qb->where('c.city = :city');
        $qb->leftJoin('c.indicator', 'i');
        $qb->andWhere('i.code = :code');
        
        $qb->setParameter('city', $city);
        $qb->setParameter('code', $indicatorCode);
        
        return $qb->getQuery()->getOneOrNullResult();
    }
}
