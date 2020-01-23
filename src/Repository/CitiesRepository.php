<?php

namespace App\Repository;

use App\Entity\Cities;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method Prices|null find($id, $lockMode = null, $lockVersion = null)
 * @method Prices|null findOneBy(array $criteria, array $orderBy = null)
 * @method Prices[]    findAll()
 * @method Prices[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CitiesRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Cities::class);
    }
    
    public function findByParams(array $param){
        
        $qb = $this->createQueryBuilder("c");
        if($param['dpt'] !== null){
            $qb->leftJoin('App:Departments', 'd', 'WITH', 'd.code = c.departmentCode');
            $qb->where('d.code = :dpt');
            $qb->setParameter('dpt', $param['dpt']->getCode());
        }
        
        // traiter les min max a la suite
        
        
        return $qb->getQuery()->getResult();
    }

    
}
