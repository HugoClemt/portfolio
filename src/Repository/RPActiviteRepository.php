<?php

namespace App\Repository;

use App\Entity\RPActivite;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method RPActivite|null find($id, $lockMode = null, $lockVersion = null)
 * @method RPActivite|null findOneBy(array $criteria, array $orderBy = null)
 * @method RPActivite[]    findAll()
 * @method RPActivite[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class RPActiviteRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, RPActivite::class);
    }

    // /**
    //  * @return RPActivite[] Returns an array of RPActivite objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('r')
            ->andWhere('r.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('r.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?RPActivite
    {
        return $this->createQueryBuilder('r')
            ->andWhere('r.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
