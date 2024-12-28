<?php

namespace App\EntityListener;


use App\Entity\Trick;
use Doctrine\ORM\Events;

use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Component\Mailer\MailerInterface;
use Doctrine\Persistence\Event\LifecycleEventArgs;
use Doctrine\Bundle\DoctrineBundle\Attribute\AsEntityListener;

class TrickListener {


    // 
    private  MailerInterface $mailer;
    public function __construct(MailerInterface $mailer){

        $this->mailer = $mailer;

 }

//procédure : 

/*
1 - je crée la class TrickListener dans le dossier EntityListener
2 - je crée la fonction postPersist avec en argument LifecycleEventArgs qui contient tous les informations liées l'evenemnt
3 - Pour que notre fonction postPersist soit considéré comme un écouteur d'évenement il faut la methode d'annoatation AsEntityListener au dessus ai a son argument :
            - l'evenement : Events::postPersist
            - la méthode qui sera déclanché
            - et l'entité concerné

donc ici l'evenement se déclenche lorsqu'on persiste l'entité trick et la methode postPersist écoute  l'évenement en envoyant l'email à l'admin

sachant qu'on accede à lentité trick par LifecycleEventArgs $args qui contien aussi l'entityManager

*/
#[AsEntityListener(event: Events::postPersist, method: 'postPersist', entity: Trick::class)]
    public function postPersist(LifecycleEventArgs $args): void
    {
       // dd($args);
        $trick = $args->getObject();
     //   dd($trick);
        if($trick instanceof Trick){
      //  dd($trick->getUser()->getEmail());
        $email = (new TemplatedEmail())
        ->from($trick->getUser()->getEmail())
        ->to("admin@gmail.com")
        ->subject("Ajout d'astuce de la part de ". $trick->getUser()->getUsername() )
        ->htmlTemplate("emails/trick_notified.html.twig")
        ->context(compact('trick') ); 
            

        $this->mailer->send($email);
        
    }
    }





} 



