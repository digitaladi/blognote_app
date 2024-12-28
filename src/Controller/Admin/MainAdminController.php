<?php


namespace App\Controller\Admin;

use App\Repository\TrickRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
// 
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

class MainAdminController  extends AbstractController{


/**
 * this function display all tricks
 *
 * @param TrickRepository $trickRepository
 * @return Response
 */

 //Permet de tous les methodes de cet controller sont accesible si on a le role admin
//#[IsGranted('ROLE_ADMIN')]
#[Route('/admin/index', name:"app_admin")]
    public function getTricks( TrickRepository $trickRepository ) : Response{

      // $tricks =  $trickRepository->findAll();
        //dd($tricks);
        return $this->render('admin/index.html.twig', [
         //   'tricks' => $tricks,
            //'is_actif' => true
        ]);
    }






    
}