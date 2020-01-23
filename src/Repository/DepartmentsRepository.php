<?php

namespace App\Repository;

use App\Entity\Departments;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method Prices|null find($id, $lockMode = null, $lockVersion = null)
 * @method Prices|null findOneBy(array $criteria, array $orderBy = null)
 * @method Prices[]    findAll()
 * @method Prices[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class DepartmentsRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Departments::class);
    }

    
}
