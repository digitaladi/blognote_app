<?php
namespace App\Controller\Admin;

use App\Entity\User;
use App\Form\EditUserAdminType;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

//Permet de tous les methodes de cet controller sont accesible si on a le role admin
//#[IsGranted('ROLE_ADMIN')]
#[Route('/admin/users', name:"app_admin_user_")]
class UserAdminController extends AbstractController {




/**
 * fonction pour récuperer tous les users (coté admin)
 *
 * @param UserRepository $userRepository
 * @return Response
 */
#[Route('/', name:"index")]
public function getUsers(UserRepository $userRepository): Response{

$users = $userRepository->findAll();
//dd($users->getTricks());
/*
foreach($users as $user) {
  dd( $user->getTricks()) ;
}

*/
return $this->render('admin/user/index.html.twig', [
    'users' => $users,
    //'is_actif' => true
]);

// 
}




#[Route('/edit/{id}', name:"edit", methods: ['GET', 'POST'])]
/**
 * Ajouter un utilisateur (coté admin)
 *
 * @param User $user
 * @param EntityManagerInterface $em
 * @param Request $request
 * @return Response
 */
public function edit(User $user, EntityManagerInterface $em, Request $request): Response{

    $userFormAdmin = $this->createForm(EditUserAdminType::class, $user);
    
   //dd($userFormAdmin);
    $userFormAdmin->handleRequest($request);
  
    if($userFormAdmin->isSubmitted() && $userFormAdmin->isValid()){
 
       // dd("fff");

        $em->persist($user);
        $em->flush();

        $this->addFlash('success', 'L\'utilisateur a été modifiée');
        return $this->redirectToRoute('app_admin_user_index');
    }

        return $this->render('admin/user/edit.html.twig', [
        'userFormAdmin' => $userFormAdmin,
    ]);
}




#[Route('/delete/{id}', name:"delete")]
/**
 * Supprimer un utilisateur (coté admin)
 *
 * @param User $user
 * @param EntityManagerInterface $em
 * @return Response
 */
public function delete(User $user, EntityManagerInterface $em):Response{


    if($user){
        $em->remove($user);
        $em->flush();
        $this->addFlash('success', 'L\'utilisateur  a été supprimé');
        return $this->redirectToRoute('app_admin_user_index');
    }else{
        $this->addFlash('warning', 'L\'utilisateur n a pas été trouvé');
    }


 }







#[Route('/show/{id}', name:"show")]
/**
 * Afficher un utilisateur (coté admin)
 *
 * @param User $user
 * @param EntityManagerInterface $em
 * @return void
 */
public function show(User $user, EntityManagerInterface $em){
    //dd($user);
    if(!$user){
        throw $this->createNotFoundException("Cet utilisiteur n'existe pas");
       }

    return $this->render('admin/user/show.html.twig', ['user' => $user]);

}







}