<?php

// src/EventListener/ExceptionListener.php
namespace App\EventListener;

use Twig\Environment;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Event\ExceptionEvent;
use Symfony\Component\HttpKernel\Exception\HttpExceptionInterface;


//cet listener ne marche pas c'est juste pour tester j'ai décommenter les parametres avec lequle il est lié dans services.yml
class ExceptionListener
{


    public function __construct( private Environment $twig){

    }


    public function __invoke(ExceptionEvent $event): void
    {   
        // You get the exception object from the received event
        $exception = $event->getThrowable();
     
if($event->getRequest()->server->get('APP_ENV') === 'prod'){
        if (!$exception instanceof HttpExceptionInterface ) {
            return;
        }

       // dd($event);
//if(function_exists($exception->getStatusCode())){
            $message = null;

    

        //  dd($event->getRequest()->server->get('HTTP_HOST'));  

        $urlhome = $event->getRequest()->server->get('HTTP_HOST');

        // Customize your response object to display the exception details
        $response = new Response();
     
        // the exception message can contain unfiltered user input;
        // set the content-type to text to avoid XSS issues
        $response->headers->set('Content-Type', 'text/plain; charset=utf-8');

        // HttpExceptionInterface is a special type of exception that
        // holds status code and header details
        if ($exception instanceof HttpExceptionInterface) {
            $response->setStatusCode($exception->getStatusCode());
            $response->headers->replace($exception->getHeaders());

       

        } else {
            $response->setStatusCode(Response::HTTP_INTERNAL_SERVER_ERROR);
        }



/*

            if($response->getStatusCode() === 404){
                $message =  "Désolé, la page que vous cherchez est introuvable";
            }elseif($response->getStatusCode() === 403){
                $message = "Vous n'êtes pas autorisé";
            }elseif($exception->getStatusCode() === 500){
                $message = "Une erreur de serveur est survenu";
            }
*/

     //   dd($response->getStatusCode());
        $htmlContent =  $this->twig->render('errors/exception_error.html.twig', ['statusCode' => $response->getStatusCode(), 'message' => $message, 'urlhome' =>$urlhome]);
        $response->setContent($htmlContent);



     //   dd($response);
        // sends the modified response object to the event

          
            $event->setResponse($response);
 
    }
}
    
}