<?php

namespace App\Repository;

use App\Entity\DomaineStage;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method DomaineStage|null find($id, $lockMode = null, $lockVersion = null)
 * @method DomaineStage|null findOneBy(array $criteria, array $orderBy = null)
 * @method DomaineStage[]    findAll()
 * @method DomaineStage[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class DomaineStageRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, DomaineStage::class);
    }

    // /**
    //  * @return DomaineStage[] Returns an array of DomaineStage objects
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
    public function findOneBySomeField($value): ?DomaineStage
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
