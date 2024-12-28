<?php

namespace App\DataFixtures;

use App\Entity\Categorie;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\String\Slugger\SluggerInterface;

class CategorieFixtures extends Fixture 

{

    //nouveauté php 8 : on peut appeller une dépendance comme celle ci private readonly SluggerInterface $slugger
    public function __construct(private readonly SluggerInterface $slugger)
    {
        
    }

public function load(ObjectManager $manager)
{
    
    //$categories = [ 'Bricolage', 'Santé', 'Bien-etre', 'Travail', 'Sport', 'Décoration', 'Informatique', 'Couple'  ];

    $categories = [
        [ 'name' => 'Informatique', 'parent' => null],
        [ 'name' => 'Santé', 'parent' => null],
        [ 'name' => 'Couple', 'parent' => null],
        [ 'name' => 'Bricolage', 'parent' => null],
        [ 'name' => 'Décoration', 'parent' => null],
        [ 'name' => 'Bien-etre', 'parent' => null],
        [ 'name' => 'Travail', 'parent' => null],
        
        [ 'name' => 'Mariage', 'parent' => 'Couple'],
        [ 'name' => 'Maladie', 'parent' => 'Santé'],
        [ 'name' => ' Développement web', 'parent' => 'Informatique'],

    ];


    foreach ($categories as  $categorie) {
        # code...
        $newCategorie = new Categorie();
        $newCategorie->setName($categorie['name']);
        $slug = strtolower($this->slugger->slug($newCategorie->getName()));
        $newCategorie->setSlug($slug);

        //on crée une référence à cette catégorie donc  $categorie["name"] fait rférence à $newCategorie
        $this->setReference($categorie["name"], $newCategorie);
        $parent = null;

        //On vérifie si la catégorie a un parent
        if($categorie["parent"] !== null){
            //on récupère la réference
            $parent = $this->getReference($categorie["parent"]);
        }
     

        $newCategorie->setParent($parent);

        $manager->persist($newCategorie);

    }



    $manager->flush();

    //pour lancer les fixtures on lance dans le terminal : 
    // symfony console d:f:l   
    
}

}