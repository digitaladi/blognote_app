<?php

namespace App\Controller\Admin;

use App\Entity\Rating;
use App\Form\AddRatingAdminType;
use App\Repository\RatingRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

//Permet de tous les methodes de cet controller sont accesible si on a le role admin
//#[IsGranted('ROLE_ADMIN')]
#[Route('/admin/rating', name: 'app_admin_rating_')]
/**
 * Page d'accueil de la notation (coté admin)
 */
Class RatingAdminController extends AbstractController{

    #[Route('/', name: 'index')]
    public function index(RatingRepository $ratingRepository): Response  
    {   
        $ratings = $ratingRepository->findAll();
        return $this->render('admin/rating/index.html.twig', [
            'ratings' => $ratings,
        ]);
    }







    #[Route('/add', name: 'add')]
    /**
     * Ajouter une notation (coté admin)
     *
     * @param Request $request
     * @param EntityManagerInterface $em
     * @return Response
     */
    public function add(Request $request, EntityManagerInterface $em): Response
    {
        //on initialise un mot clé
        $rating = new Rating();

      


        //on initialise le formulaire lié au  mot clé
        $ratingForm = $this->createForm(AddRatingAdminType::class, $rating);


          //on traite le formualaire
          $ratingForm->handleRequest($request);

                //on vérifie si le formulaire est envoyé et  valide 
                if($ratingForm->isSubmitted() && $ratingForm->isValid()){

 
                $em->persist($rating);
                $em->flush();

                $this->addFlash('success', 'La notation a été ajouté');
                return $this->redirectToRoute('app_admin_rating_index');
            }


        return $this->render('admin/rating/add.html.twig', [
            'ratingForm' => $ratingForm,
        ]);
    }








    #[Route('/edit/{id}', name:"edit", methods: ['GET', 'POST'])]
    /**
     * Editer une notation (coté admin)
     *
     * @param EntityManagerInterface $em
     * @param Rating $rating
     * @param Request $request
     * @return void
     */
    public function edit(EntityManagerInterface $em, Rating $rating, Request $request){
        $ratingEditAdminForm = $this->createForm(AddRatingAdminType::class, $rating);
        $ratingEditAdminForm->handleRequest($request);
        if($ratingEditAdminForm->isSubmitted() && $ratingEditAdminForm->isValid()){
     
            $em->persist($rating);
            $em->flush();
    
            $this->addFlash('success', 'La notation  a été modifié');
            return $this->redirectToRoute('app_admin_rating_index');
    
          }


        return $this->render('admin/rating/edit.html.twig', [
        'ratingEditAdminForm' => $ratingEditAdminForm,
        ]);
    }



    #[Route('/show/{id}', name:"show")]
    /**
     * Afficher  une notation (coté admin)
     *
     * @param Rating $rating
     * @return Response
     */
    public function show(Rating $rating): Response{
        
      // dd($categorie);

       if(!$rating){
        throw $this->createNotFoundException("Cette notation n'existe pas ");
       }
        return $this->render('admin/rating/show.html.twig', [
            'rating' => $rating,
        ]);
    }



    #[Route('/delete/{id}', name:"delete")]
    /**
     * Supprimer une notation (coté admin)
     *
     * @param Rating $rating
     * @param EntityManagerInterface $em
     * @return Response
     */
    public function deleteTrickAdmin(Rating $rating, EntityManagerInterface $em):Response{


        if($rating){
            $em->remove($rating);
            $em->flush();
            $this->addFlash('success', 'La notation a été supprimé');
            return $this->redirectToRoute('app_admin_rating_index');
        }else{
            $this->addFlash('warning', 'La notation n\' a pas été trouvé');
        }


}


}