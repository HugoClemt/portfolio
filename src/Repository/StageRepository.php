<?php

namespace App\Repository;

use App\Entity\Stage;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Stage|null find($id, $lockMode = null, $lockVersion = null)
 * @method Stage|null findOneBy(array $criteria, array $orderBy = null)
 * @method Stage[]    findAll()
 * @method Stage[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class StageRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Stage::class);
    }

    // /**
    //  * @return Stage[] Returns an array of Stage objects
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
    public function findOneBySomeField($value): ?Stage
    {
        return $this->createQueryBuilder('s')
            ->andWhere('s.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */

    public function findByStageIdAndJourLibelle($stage_id){
        $em = $this->getEntityManager();

        return $em->createQuery(
            'SELECT jour.libelle, domaine_taches.libelle, tache_semaine.duree, tache_semaine.description 
                FROM App\Entity\DomaineTaches domaine_taches, App\Entity\TacheSemaine tache_semaine, App\Entity\SemaineStage semaine_stage, App\Entity\Stage stage, App\Entity\Jour libelle 
                WHERE stage.id = semaine_stage.stage_id 
                    and semaine_stage.id = tache_semaine.semaine_stage_id 
                    and tache_semaine.domaine_id = domaine_taches.id 
                    and tache_semaine.jour_id = jour.id
                    and stage.id = :stage_id' 
        )
        ->setParameter('stage_id', $stage_id)
        ->getResult();
    }
}
