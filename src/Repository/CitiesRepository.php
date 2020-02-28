<?php

namespace App\Repository;

use App\Entity\Cities;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;
use App\Entity\User;

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
        
        $qb->leftJoin('App:Prices', 'p', 'WITH', 'p.city = c.id');
        if($param['price']['min']){
            $qb->andWhere('p.priceMeter > :min');
            $qb->setParameter('min', $param['price']['min']);
        }
        
        if($param['price']['max']){
            $qb->andWhere('p.priceMeter < :max');
            $qb->setParameter('max', $param['price']['max']);
        }
        
        $qb->leftJoin('App:Population', 'pop', 'WITH', 'pop.city = c.id');
        if($param['population']['min']){
            $qb->andWhere('pop.total > :min');
            $qb->setParameter('min', $param['population']['min']);
        }
        
        if($param['population']['max']){
            $qb->andWhere('pop.total < :max');
            $qb->setParameter('max', $param['population']['max']);
        }
        
        
        return $qb->getQuery()->getResult();
    }
    
    public function findByQuery($query){
        $qb = $this->createQueryBuilder("c");
        $qb->select('c.inseeCode, c.name, c.slug, c.zipCode');
        $qb->where('LOWER(c.name) LIKE LOWER(:query)');
        $qb->andWhere('c.inseeCode IS NOT NULL');
        $qb->setParameter('query', '%'.$query.'%');
        $qb->orderBy('c.name', 'ASC');
        
        return $qb->getQuery()->getArrayResult();
    }


    public function findByUsers(User $user){        
        $qb = $this->createQueryBuilder("c");
        $qb->leftJoin('c.users', 'u');
        $qb->where('u.id = :id');
        $qb->setParameter('id', $user->getId());
        
        return $qb->getQuery()->getResult();
    }
    
    public function findByNoIndicator($departement = null){
        $qb = $this->createQueryBuilder("c");
        $qb->leftJoin('c.indicatorValues', 'iv');
        $qb->where('iv.city IS NULL');
        if($departement !== null){
            $qb->andWhere('c.departmentCode = :department');
            $qb->setParameter("department", $departement);
        }
        
        return $qb->getQuery()->getResult();
    }
    
    public function findByNoPrices($departement = null){
        $qb = $this->createQueryBuilder("c");
        $qb->leftJoin('c.price', 'p');
        $qb->where('p.city IS NULL');
        if($departement !== null){
            $qb->andWhere('c.departmentCode = :department');
            $qb->setParameter("department", $departement);
        }
        
        return $qb->getQuery()->getResult();
    }

    
}
