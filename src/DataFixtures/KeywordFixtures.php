<?php

namespace App\DataFixtures;

use App\Entity\Keyword;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\String\Slugger\SluggerInterface;

class KeywordFixtures extends Fixture 

{

    //nouveauté php 8 : on peut appeller une dépendance depuis le parametre de la fonction __contruct comme celle ci private readonly SluggerInterface $slugger
    public function __construct(private readonly SluggerInterface $slugger)
    {
        
    }

public function load(ObjectManager $manager)
{
    $keywords = [ 'Bricolage', 'Santé', 'Bien-etre', 'Travail', 'Sport', 'Décoration', 'Informatique', 'Couple' ];


    foreach ($keywords as  $value) {
        # code...
        $newKeyword = new Keyword();
        $newKeyword->setName($value);
        $slug = strtolower($this->slugger->slug($newKeyword->getName()));
        $newKeyword->setSlug($slug);
        $manager->persist($newKeyword);

    }



    $manager->flush();

    //pour lancer les fixtures on lance dans le terminal : 
    // symfony console d:f:l   
    
}

}