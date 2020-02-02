<?php

namespace App\Repository;

use App\Entity\Performances;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method Performances|null find($id, $lockMode = null, $lockVersion = null)
 * @method Performances|null findOneBy(array $criteria, array $orderBy = null)
 * @method Performances[]    findAll()
 * @method Performances[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class PerformancesRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Performances::class);
    }

    // /**
    //  * @return Performances[] Returns an array of Performances objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('p.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Performances
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
