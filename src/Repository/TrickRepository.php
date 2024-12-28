<?php

namespace App\Repository;

use App\Entity\Trick;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Trick>
 */
class TrickRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Trick::class);
    }

    //    /**
    //     * @return Trick[] Returns an array of Trick objects
    //     */
    //    public function findByExampleField($value): array
    //    {
    //        return $this->createQueryBuilder('t')
    //            ->andWhere('t.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->orderBy('t.id', 'ASC')
    //            ->setMaxResults(10)
    //            ->getQuery()
    //            ->getResult()
    //        ;
    //    }

    //    public function findOneBySomeField($value): ?Trick
    //    {
    //        return $this->createQueryBuilder('t')
    //            ->andWhere('t.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }


    

        public function trickByCategory(): array
       {

     //  dd("ok");
          //sleep permet de faire une pause avant le rendu
    // sleep(3);
       return $this->createQueryBuilder('t') //la lettre t est une alias de la table trick
                  //  ->select('t')
                 //   ->from('Trick', 't') //
                 //   ->leftJoin('t.categories', 'c')
                 //   ->orderBy('t.title', 'ASC') //par ordre title par  ascendant 
                    //->setMaxResults(2) //le nombre de ligne 
                    //->join('t.categorie', 'c')
                //    ->addSelect('c')
                   ->where('t.public = 1')
                     //->addSelect("c")
                           //  ->select('c')    
                 //    ->from('categorie', 'c')
                 //   ->join("c.name", "trick")
                  //  ->groupBy('t.categorie')
                    ->getQuery()
                    ->getResult()
           ;
       }


/*
       public function trickByCategoryOlRequest(){

        /*
        $sql = "SELECT * FROM trick";

        $stmt = $this->getEntityManager()->getConnection()->prepare($sql);
    //    $stmt->execute([]);
    
        return $stmt->fetch;

       }

return true;

}
*/





    }