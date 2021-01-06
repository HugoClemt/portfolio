<?php

namespace App\Repository;

use App\Entity\TacheSemaine;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method TacheSemaine|null find($id, $lockMode = null, $lockVersion = null)
 * @method TacheSemaine|null findOneBy(array $criteria, array $orderBy = null)
 * @method TacheSemaine[]    findAll()
 * @method TacheSemaine[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class TacheSemaineRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, TacheSemaine::class);
    }

    // /**
    //  * @return TacheSemaine[] Returns an array of TacheSemaine objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('t')
            ->andWhere('t.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('t.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?TacheSemaine
    {
        return $this->createQueryBuilder('t')
            ->andWhere('t.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
