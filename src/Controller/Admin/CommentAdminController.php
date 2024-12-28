<?php


namespace App\Controller\Admin;

use App\Entity\Comment;
use App\Form\AddCommentAdminType;
use App\Repository\CommentRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

//Permet de tous les methodes de cet controller sont accesible si on a le role admin
//#[IsGranted('ROLE_ADMIN')]
#[Route('/admin/comment', name: 'app_admin_comment_')]
/**
 *   page index de commmentaire  (coté admin)
 */
Class CommentAdminController extends AbstractController{


    #[Route('/', name: 'index')]
    public function index(CommentRepository $commentRepository){

        $comments = $commentRepository->findAll();
        //dd($comments);
        return $this->render('admin/comment/index.html.twig', [
            'comments' => $comments,
        ]);



    }




    #[Route('/add', name: 'add')]
    /**
     * Ajouter un commentaire (coté admin)
     *
     * @param Request $request
     * @param EntityManagerInterface $em
     * @return void
     */
    public function add(Request $request,EntityManagerInterface $em){
        $comment = new Comment();
        //dd($comment);
      $commentAdminForm =   $this->createForm(AddCommentAdminType::class, $comment);
      $commentAdminForm->handleRequest($request);
      //dd($commentAdminForm);
      if($commentAdminForm->isSubmitted() && $commentAdminForm->isValid()){
     
        $em->persist($comment);
        $em->flush();

        $this->addFlash('success', 'Le commentaire  a été ajoutée');
        return $this->redirectToRoute('app_admin_comment_index');

      }

        return $this->render('admin/comment/add.html.twig', [
            'commentAdminForm' => $commentAdminForm,
        ]);


    }


    #[Route('/edit/{id}', name:"edit", methods: ['GET', 'POST'])]
    /**
     * Editer un commentaire (coté admin)
     *
     * @param EntityManagerInterface $em
     * @param Comment $comment
     * @param Request $request
     * @return void
     */
    public function edit(EntityManagerInterface $em, Comment $comment, Request $request){
        $commentEditAdminForm = $this->createForm(AddCommentAdminType::class, $comment);
        $commentEditAdminForm->handleRequest($request);
        if($commentEditAdminForm->isSubmitted() && $commentEditAdminForm->isValid()){
     
            $em->persist($comment);
            $em->flush();
    
            $this->addFlash('success', 'Le commentaire  a été modifié');
            return $this->redirectToRoute('app_admin_comment_index');
    
          }


        return $this->render('admin/comment/edit.html.twig', [
        'commentAdminForm' => $commentEditAdminForm,
        ]);
    }



    #[Route('/show/{id}', name:"show")]
    /**
     * Afficher un commentaire (coté admin)
     *
     * @param Comment $comment
     * @return Response
     */
    public function show(Comment $comment): Response{
        
      // dd($categorie);

       if(!$comment){
        throw $this->createNotFoundException("Ce commentaire n'existe pas ");
       }
        return $this->render('admin/comment/show.html.twig', [
            'comment' => $comment,
        ]);
    }


    #[Route('/delete/{id}', name:"delete")]
    /**
     * Supprimer un commentaire (coté admin)
     *
     * @param Comment $comment
     * @param EntityManagerInterface $em
     * @return Response
     */
    public function deleteTrickAdmin(Comment $comment, EntityManagerInterface $em):Response{


        if($comment){
            $em->remove($comment);
            $em->flush();
            $this->addFlash('success', 'Le commentaire a été supprimé');
            return $this->redirectToRoute('app_admin_comment_index');
        }else{
            $this->addFlash('warning', 'La catégorie n a pas été trouvé');
        }


}



}