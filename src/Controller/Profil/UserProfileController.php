<?php
namespace App\Controller\Profil;

use App\Entity\Trick;
use App\Entity\User;
use App\Form\EditUserPasswordType;
use App\Form\UserProfileEditType;
use App\Service\PictureService;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\ExpressionLanguage\Expression;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;
use Symfony\Component\String\Slugger\SluggerInterface;

#[Route('/profile/user', name:"app_profile_user_")]
Class UserProfileController extends AbstractController{


  // l'utilisateur connecté correponds  au user passé en argument(choosenUser)
    #[IsGranted(new Expression('user === subject'), subject: 'choosenUser')]
    #[Route('/{id}', name:"index")]

    /**
     * cette fonction affiche la gestion du profil de l'utilisateur connecté
     *
     * @param User $user
     * @param Request $request
     * @param EntityManagerInterface $em
     * @param UserPasswordHasherInterface $hasher
     * @return Response
     */
    public function index(User $choosenUser, Request $request, EntityManagerInterface $em, UserPasswordHasherInterface $hasher): Response{
    

/*

      //si l'utilisateur n'est pas connecté
  if(!$this->getUser()){
      return $this->redirectToRoute("app_login ");

}

  //si l'utilisateur connecté ne correponds pas à l'utilisateur en parametre
  if($this->getUser() !== $user){
  return $this->redirectToRoute("app_profile_main_index");

}

*/


$formEditUserPassword = $this->createForm(EditUserPasswordType::class);
$formEditUserPassword->handleRequest($request);

if($formEditUserPassword->isSubmitted() && $formEditUserPassword->isValid()){
 // dd($formEditUserPassword->getData()['password']);
  if($hasher->isPasswordValid($choosenUser, $formEditUserPassword->getData()['password'])){
  
      $choosenUser->setPassword($hasher->hashPassword($choosenUser, $formEditUserPassword->getData()['newpassword']) );
      $em->persist($choosenUser);
      $em->flush();
      $this->addFlash('success', 'Le mot de passe a été modifié');
      return $this->redirectToRoute('app_profile_user_index', array('id' => $choosenUser->getId()));
  }else{
    $this->addFlash('warning', 'Le mot de passe renseigné est incorrect');
    //return $this->redirectToRoute('app_profile_user_index', array('id' => $user->getId()));
  }


}





$formeditUser = $this->createForm(UserProfileEditType::class, $choosenUser);
$formeditUser->handleRequest($request);
if($formeditUser->isSubmitted() && $formeditUser->isValid()){
//if($hasher->isPasswordValid($user, $formeditUser->getData()->getPassword())){
  //dd($user);
  $em->persist($choosenUser);
  $em->flush();
  $this->addFlash('success', 'Votre profil a été modifié');
  return $this->redirectToRoute('app_profile_user_index', array('id' => $choosenUser->getId()));
//}else{
  //$this->addFlash('warning', 'Le mot de passe renseigné est incorrect');
//}



}





    return $this->render('profil/user/index.html.twig', [
      "formeditUser" =>  $formeditUser,
      'formEditUserPassword' => $formEditUserPassword

       // 'users' => $users,
      //  
       
        //'is_actif' => true
    ]);
    
    // 
    }










}