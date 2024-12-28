<?php

namespace App\Repository;

use App\Entity\Categorie;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Categorie>
 */
class CategorieRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Categorie::class);
    }

    //    /**
    //     * @return Categorie[] Returns an array of Categorie objects
    //     */
    //    public function findByExampleField($value): array
    //    {
    //        return $this->createQueryBuilder('c')
    //            ->andWhere('c.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->orderBy('c.id', 'ASC')
    //            ->setMaxResults(10)
    //            ->getQuery()
    //            ->getResult()
    //        ;
    //    }

    //    public function findOneBySomeField($value): ?Categorie
    //    {
    //        return $this->createQueryBuilder('c')
    //            ->andWhere('c.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }






    public function tricksByCategory(): array
    {

    return $this->createQueryBuilder('c') //la lettre t est une alias de la table trick
                ->select('c', 't')
                //->from('categorie', 'c') //
                 ->leftJoin('c.tricks', 't')
                //->groupBy('c.name')
                 //->orderBy('t.title', 'ASC') //par ordre title par  ascendant 
                 //->setMaxResults(2) //le nombre de ligne 
                 //->join('t.categorie', 'c')
                 //->addSelect('c')
              //   ->where('t.categorie_id = c.id')
                  //->addSelect("c")
                        //  ->select('c')    
              //    ->from('categorie', 'c')
              //   ->join("c.name", "trick")
               //  ->groupBy('t.categorie')
                 ->getQuery()
                // ->getResult()
                 ->getArrayResult();
                 
        ;
    }





}
