<?php



namespace App\Service;

use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Component\Mailer\MailerInterface;

class SendEmailService {
    public function __construct(private MailerInterface $mailer)
    {
        
    }


    //cette fonction sera utliser dans le controller RegistrationController dans la fonction register 
    //permet d'envoyer un mail après inscription et génération de token
    public function send(
        string $from,
        string $to,
        string $subject,
        string $template,
        array  $context

    ): void{
    
        //on crée le mail
        $email = (new TemplatedEmail())
         ->from($from)
         ->to($to)
         ->subject($subject)
         ->htmlTemplate("emails/$template.html.twig")
         //les variables du context seront accessible dans le template
         ->context($context); //qui permet d'envoyer des variables comme le token ou le user

         //on envoie le mail

    
        $this->mailer->send($email);


        
    }
}