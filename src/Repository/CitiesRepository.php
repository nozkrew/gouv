<?php

namespace App\Repository;

use App\Entity\Cities;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method Prices|null find($id, $lockMode = null, $lockVersion = null)
 * @method Prices|null findOneBy(array $criteria, array $orderBy = null)
 * @method Prices[]    findAll()
 * @method Prices[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CitiesRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Cities::class);
    }
    
    public function findByParams(array $param){
        
        $qb = $this->createQueryBuilder("c");
        if($param['dpt'] !== null){
            $qb->leftJoin('App:Departments', 'd', 'WITH', 'd.code = c.departmentCode');
            $qb->andWhere('d.code IN (:dpt)');
            $qb->setParameter('dpt', $param['dpt']);
        }
        
        if($param['price']['min']){
            $qb->leftJoin('App:Prices', 'p', 'WITH', 'p.city = c.id');
            $qb->andWhere('p.priceMeter > :min');
            $qb->setParameter('min', $param['price']['min']);
        }
        
        if($param['price']['max']){
            $qb->leftJoin('App:Prices', 'p', 'WITH', 'p.city = c.id');
            $qb->andWhere('p.priceMeter < :max');
            $qb->setParameter('max', $param['price']['max']);
        }
        
        if($param['population']['min']){
            $qb->leftJoin('App:Population', 'pop', 'WITH', 'pop.city = c.id');
            $qb->andWhere('pop.total > :min');
            $qb->setParameter('min', $param['population']['min']);
        }
        
        if($param['population']['max']){
            $qb->leftJoin('App:Population', 'pop', 'WITH', 'pop.city = c.id');
            $qb->andWhere('pop.total < :max');
            $qb->setParameter('max', $param['population']['max']);
        }
        
        
        return $qb->getQuery()->getResult();
    }

    
}
