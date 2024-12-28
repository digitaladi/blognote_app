<?php

namespace App\EventSubscriber;

use App\Entity\User;
use DateTimeImmutable;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\HttpFoundation\RedirectResponse;
//use Symfony\Component\HttpFoundation\Session\Flash\FlashBagInterface;
use Symfony\Component\Security\Http\Event\LogoutEvent;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;


class LogoutSubscriber implements EventSubscriberInterface
{

    private EntityManagerInterface $em;
    private RequestStack $requestStack;
    public function __construct(EntityManagerInterface $em, RequestStack $requestStack){
        $this->em = $em;
        $this->requestStack = $requestStack;
    }


    public function onEventLogout($event): void
    {

       // $urlhome = $event->getRequest()->server->get('HTTP_HOST');
        $user = $event->getToken()->getUser();

        if (!$user instanceof User) {
            return;
        }


        //$this->requestStack->getSession()->get('storage')
      //  dd($this->requestStack->getSession()->getFlashBag()->add('success', "Vous êtes deconnecté !"));
        $user->setLastLogin(new DateTimeImmutable());
        $this->em->persist($user);
        $this->em->flush();

       // $this->flash->add('success', "Vous êtes deconnecté !");
       $this->requestStack->getSession()->getFlashBag()->add('success', "Vous êtes deconnecté !");
       // $event->setResponse(new RedirectResponse($urlhome));
        //dd($user);
        // ...
    }

    public static function getSubscribedEvents(): array
    {
        return [
            LogoutEvent::class => 'onEventLogout',
        ];
    }
}
