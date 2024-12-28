<?php

namespace App\Command;

use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;
use Symfony\Component\Console\Question\Question;
use Doctrine\ORM\EntityManagerInterface;
use App\Entity\User;


//CETTE COMMANDE D ATTRIBUER UN UTILISATEUR LE ROLE ADMIN
//symfony console app:devenir-administrateur
#[AsCommand(
    name: 'app:devenir-administrateur',
    description: 'Mettre accorder le role ADMIN à un utilisateur',
)]
class DevenirAdministrateurCommand extends Command
{

  
    private ?EntityManagerInterface $entityManager;
    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
        parent::__construct();
    }

    protected function configure(): void
    {
        //ajout d'argument de commande
        $this
            ->addArgument('email', InputArgument::OPTIONAL, 'Email de l\'utilisateur concernée')
            //->addOption('option1', null, InputOption::VALUE_NONE, 'Option description')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
     
        $io = new SymfonyStyle($input, $output);

        $helper = $this->getHelper('question');

        
        $emailArg = $input->getArgument('email');

        if(!$emailArg){
            $question = new Question('Veuillez rentrer l\'email de l\'utilisateur : ');

            //on pose la question
            $emailArg =  $helper->ask($input, $output, $question);
        }

     $user =   $this->entityManager->getRepository(User::class)->findOneBy(['email' => $emailArg ]);
       // dd($user);

            if(!$user){
                $io->error( 'Cet utilisateur  n\'existe pas ');
                return Command::SUCCESS;
            }


            $user->setRoles(['ROLE_USER', 'ROLE_ADMIN']);
            $this->entityManager->persist($user);
            $this->entityManager->flush();



        $io->success( 'L\'utilisateur '.$emailArg . '  a maintenant un role admin ');
            
        return Command::SUCCESS;
    }
}
