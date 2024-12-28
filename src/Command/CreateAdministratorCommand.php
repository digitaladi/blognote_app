<?php

namespace App\Command;

use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Question\Question;
use Symfony\Component\Console\Style\SymfonyStyle;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

// le commande à taper : symfony console app:create-administrator
//cette commande n'est pas partinente c'est pour voir le concept
#[AsCommand(
    name: 'app:create-administrator', //nom de la commande 
    description: 'Permet de créer une commande', //le descriptif de la commande
)]
class CreateAdministratorCommand extends Command
{
    private EntityManagerInterface $entityManager;
    private UserPasswordHasherInterface $userPasswordHasher;

    public function __construct(EntityManagerInterface $entityManager, UserPasswordHasherInterface $userPasswordHasher)
    {

        $this->entityManager = $entityManager;
        $this->userPasswordHasher = $userPasswordHasher;

        //c'est obligatoire d'appller le parent constructeur si on  utilise le constructeur
        parent::__construct();
    }

    //cette fonction est facultatif pour la commande marche 
    protected function configure(): void
    {
        $this
           // ->addArgument('arg1', InputArgument::OPTIONAL, 'Argument description') //un argument de commande comme l'est upgrade dans la commande [apt upgrate] de linux
           // ->addOption('option1', null, InputOption::VALUE_NONE, 'Option description') //option de commande comme les -y dans la commande [apt upgrate -y] de linux

            //on ajoute nos arguments et options
           ->addArgument('username', InputArgument::OPTIONAL, 'Le pseudo')
           ->addArgument('email', InputArgument::OPTIONAL, 'Email') 
           ->addArgument('password', InputArgument::OPTIONAL, 'Mot de passe')
        ;
    }

    //la fonction qui sera éxécutée
    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        /*
        QuestionHelper fournit des fonctions permettant de demander à l'utilisateur des informations supplémentaires. 
        Il est inclus dans l'ensemble d'aides par défaut et vous pouvez l'obtenir en appelant getHelper() :
        */
        $helper = $this->getHelper('question');
        $io = new SymfonyStyle($input, $output);


        $usernameArgument = $input->getArgument('username'); //on déclare l'argument username

        //si l'argument $usernameArgument n'est pas défini dans terminal
        if(!$usernameArgument){
            //l'objet console est une class du composant Console qui permet de poser des questions liés auw arguments dans le terminal
             //on pose une question sur $usernameArgument
            $question =  new Question('Quel est le pseudo de l\'administrateur : ');

           
            $usernameArgument =  $helper->ask($input, $output, $question);
            
        }

        //si l'argument $emailArgument  n'est pas défini dans terminal
         //on pose une question sur $emailArgument
        $emailArgument = $input->getArgument('email'); //on déclare l'argument username
            if(!$emailArgument){
                $question =  new Question('Quel est l\'email '.$usernameArgument . ' : ');
                $emailArgument =  $helper->ask($input, $output, $question);
            }

      
        $passwordArgument = $input->getArgument('password'); //on déclare l'argument username

         //si l'argument $passwordArgument  n'est pas défini dans terminal
          //on pose une question sur $passwordArgument
        if(!$passwordArgument){
            $question =  new Question('Quel est le mot  de passe '. $usernameArgument . ' : ');
            $passwordArgument =  $helper->ask($input, $output, $question);
        }
   
        //on va créer un nouveau utilisateur 
         $user = (new User())
        ->setUsername($usernameArgument)
        ->setEmail($emailArgument)
       
        ->setActive(true)
        ->setRoles(['ROLE_USER','ROLE_ADMIN']); //avec les arguments données on passe notre user en administrateur
        $user->setPassword($this->userPasswordHasher->hashPassword($user, $passwordArgument));
        $this->entityManager->persist($user);
        $this->entityManager->flush();
      //  dd($user);




       
        $io->success('Le nouvel administrateur a été crée.');
     
        return Command::SUCCESS;
    }
}
