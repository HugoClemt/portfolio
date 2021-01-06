<?php

namespace App\Repository;

use App\Entity\RP;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method RP|null find($id, $lockMode = null, $lockVersion = null)
 * @method RP|null findOneBy(array $criteria, array $orderBy = null)
 * @method RP[]    findAll()
 * @method RP[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class RPRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, RP::class);
    }

    // /**
    //  * @return RP[] Returns an array of RP objects
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
    public function findOneBySomeField($value): ?RP
    {
        return $this->createQueryBuilder('r')
            ->andWhere('r.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */

    public function findByStatutAndEnseignant($enseignant): array
    {        
         $enseignant = new Enseignant($enseignant);  
         $qb = $this->createQueryBuilder('r')
            ->andWhere('r.enseignant = :pEnseignant', )
            ->setParameter('pEnseignant', $enseignant)
            ->orderBy('r.nom', 'ASC')
            ->getQuery();
 
        return $qb->execute();
 
    }
}
