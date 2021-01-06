<?php

namespace App\Repository;

use App\Entity\DomaineTaches;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method DomaineTaches|null find($id, $lockMode = null, $lockVersion = null)
 * @method DomaineTaches|null findOneBy(array $criteria, array $orderBy = null)
 * @method DomaineTaches[]    findAll()
 * @method DomaineTaches[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class DomaineTachesRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, DomaineTaches::class);
    }

    // /**
    //  * @return DomaineTaches[] Returns an array of DomaineTaches objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('d')
            ->andWhere('d.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('d.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?DomaineTaches
    {
        return $this->createQueryBuilder('d')
            ->andWhere('d.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
