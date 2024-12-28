<?php
namespace App\Controller\Profil;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/profile/main', name: 'app_profile_main_')]
class MainProfileController extends AbstractController{


    #[Route('/', name: 'index')]

    /**
     * page d'acueil
     *
     * @return Response
     */
    public function index(): Response {

        $page_home_profil = "Je suis la page d'accueil du profil";
  
        return $this->render('profil/index.html.twig', 
        compact('page_home_profil')
    );

    }








}