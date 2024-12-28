<?php

namespace App\DataFixtures;

use App\Entity\Trick;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\String\Slugger\SluggerInterface;

class TrickFixtures extends Fixture implements DependentFixtureInterface
{

    //nouveauté php 8 : on peut appeller une dépendance depuis le parametre de la fonction __contruct comme celle ci private readonly SluggerInterface $slugger
    public function __construct(private readonly SluggerInterface $slugger){}

    public function load(ObjectManager $manager): void
    {
         $newTrick = new Trick();
         $newTrick->setTitle("Dormir facilement");
         $newTrick->setContent("je bois beaucoups d'eau, j'eteins toutes les lumières et je dors tôt");
         $slug = strtolower($this->slugger->slug($newTrick->getTitle()));
         $newTrick->setSlug($slug);
         //ici Admin fait  référence  à $user définit dans UserFixtures : ex :$this->setReference("Admin", $$newUser);
          $newTrick->setUser($this->getReference('Admin'));
          $newTrick->setFeatureimage("image.png");
         $manager->persist($newTrick);

        $manager->flush();
    }

    //cette fonction permet à UserFixtures de séxcuter en premier.  fait avec nos fixyures il faut que UserFixtures soit éxcuté avant TrickFixtures
public function getDependencies()
{
    return [ 
        UserFixtures::class
    ];
}

}
