<?php

namespace App\EventSubscriber;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\KernelEvents;
use Symfony\Component\HttpKernel\Event\RequestEvent;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;


/*
créer le event Subscriber : LocalhostFalseSubscriber

1 - symfony console make:subscriber
            - donner le nom de class du event listener : LocalhostFalseSubscriber
            - renseigner  le event à écouter  ex : kernel.request (s'éxécute après chaque requete)


Pas de fichiers de config pour les eventSubscribers contrairement aux eventListeners

*/


//cet EventSubscriber  permet de retourner un message d'erreur si on  a pas le bon ip
class LocalhostFalseSubscriber implements EventSubscriberInterface
{
    

    
    //fonction qui s'éxecute après l'ecoute de l'evenement (KernelEvents::REQUEST = kernel.request)
    public function onKernelRequest(RequestEvent $event): void
    {

       
        if ($event->getRequest()->server->get('REMOTE_ADDR') != '172.18.0.1') {
           // dd($event->getRequest()->server->get('REMOTE_ADDR'));            
            $event->setResponse(new Response('Accés no autorisé. Vous n\' avez pas le bon IP !'));
        }
     //   dd($event);
        // ...
    }

    
    //la liste des evenements à écouter dans un tableau ['evenement' => ['methodAexécuter', priority]]
    public static function getSubscribedEvents(): array
    {
        return [
         KernelEvents::REQUEST => 'onKernelRequest',
        ];
     

          /*
     ['eventName' => 'methodName']
     ['eventName' => ['methodName', $priority]]
     ['eventName' => [['methodName1', $priority], ['methodName2']]]
          */
      
    }
}
