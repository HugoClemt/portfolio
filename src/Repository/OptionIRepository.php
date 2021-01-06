<?php

namespace App\Repository;

use App\Entity\OptionI;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method OptionI|null find($id, $lockMode = null, $lockVersion = null)
 * @method OptionI|null findOneBy(array $criteria, array $orderBy = null)
 * @method OptionI[]    findAll()
 * @method OptionI[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class OptionIRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, OptionI::class);
    }

    // /**
    //  * @return OptionI[] Returns an array of OptionI objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('o')
            ->andWhere('o.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('o.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?OptionI
    {
        return $this->createQueryBuilder('o')
            ->andWhere('o.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
