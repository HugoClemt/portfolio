<?php

namespace App\Repository;

use App\Entity\SemaineStage;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method SemaineStage|null find($id, $lockMode = null, $lockVersion = null)
 * @method SemaineStage|null findOneBy(array $criteria, array $orderBy = null)
 * @method SemaineStage[]    findAll()
 * @method SemaineStage[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class SemaineStageRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, SemaineStage::class);
    }

    // /**
    //  * @return SemaineStage[] Returns an array of SemaineStage objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('s')
            ->andWhere('s.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('s.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?SemaineStage
    {
        return $this->createQueryBuilder('s')
            ->andWhere('s.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
