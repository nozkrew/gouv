<?php

namespace App\Repository;

use App\Entity\Main\Prices;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method Prices|null find($id, $lockMode = null, $lockVersion = null)
 * @method Prices|null findOneBy(array $criteria, array $orderBy = null)
 * @method Prices[]    findAll()
 * @method Prices[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class PricesRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Prices::class);
    }
}
