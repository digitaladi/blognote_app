<?php

namespace App\Controller\Profil;


use App\Entity\Trick;
use App\Form\AddTrickFormType;
use App\Repository\TrickRepository;
use App\Repository\UserRepository;
use App\Service\PictureService;
use DateTime;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\ExpressionLanguage\Expression;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;
use Symfony\Component\String\Slugger\SluggerInterface;

//Permet de tous les methodes de cet controller sont accesible si on a le role user
//#[IsGranted('ROLE_USER')]
#[Route('/profile/trick', name: 'app_profil_trick_')]
class TrickProfileController extends AbstractController
{

   //on éxcécute cette fonction que si on n'a le role user
   // #[IsGranted('ROLE_USER')]
    #[Route('/', name: 'index')]
    public function index(TrickRepository $trickRepository, EntityManagerInterface $em, UserRepository $userRepository): Response
    {
        //on accéde ici que si on est role_user
        //$this->denyAccessUnlessGranted('ROLE_USER');

        //$lastTricks = $trickRepository->findOneBy([], ['id' => 'DESC']);

        //on récupéres les astuces de l'utilisateur connecté
        $tricks  = $trickRepository->findBy(['user' => $this->getUser()]);
       // dd($tricks);
        //on récupère les utilisateurs qui ont plus de posts par ordre 
      //  $bestAuthors = $userRepository->getUserByTricks(2);
        //dd($tricks);

        return $this->render('profil/trick/index.html.twig', 
            compact('tricks')
        );
    }




    #[Route('/add', name: 'add')]
    public function addTrick(Request $request, SluggerInterface $slugger, EntityManagerInterface $em, UserRepository $userRepository, PictureService $pictureService): Response
    {
        //on initialise  l'astuce
        $trick = new Trick();

      


        //on initialise le formulaire lié à l'astuce
        $trickForm = $this->createForm(AddTrickFormType::class, $trick);
        //dd($this->getUser());

          //on traite le formualaire
          $trickForm->handleRequest($request);

                //on vérifie si le formulaire est envoyé et  valide 
                if($trickForm->isSubmitted() && $trickForm->isValid()){

                //on crée le slug à parti du nom de l'astuce
                $slug = strtolower($slugger->slug($trick->getTitle()) );
              //     dd($this->getUser());
                $trick->setUser($this->getUser());


                //dd($slug);
                //on assgine uen valeur au slug de  l'astuce
                $trick->setSlug($slug);
                $trick->setCreatedAt(new \DateTimeImmutable());
                $trick->setUpdatedAt(new \DateTimeImmutable());
                $em->persist($trick);
                $em->flush();

                $this->addFlash('success', 'L\'astuce a été ajouté');
                return $this->redirectToRoute('app_profil_trick_index');
            }


        return $this->render('profil/trick/add.html.twig', [
            'trickForm' => $trickForm,
        ]);
    }






//  #[IsGranted(new Expression('user === subject.getUser()'), subject: 'trick')] : n'est accessible que l'utilisateur connecté à qui appartient l'astuce trick
//c'est pour éviter d'acceder à une astuce qui appartient à un autre utilisateur
    #[IsGranted(new Expression('user === subject.getUser()'), subject: 'trick')]
    #[Route('/edit/{id}', name:"edit", methods: ['GET', 'POST'])]
    /**
     * Editer une astuce (coté profil)
     *
     * @param EntityManagerInterface $em
     * @param Trick $trick
     * @param Request $request
     * @param SluggerInterface $slugger
     * @param PictureService $pictureService
     * @return Response
     */
    public function Edit(EntityManagerInterface $em, Trick $trick,Request $request, SluggerInterface $slugger, PictureService $pictureService) : Response{
            //paramconverter permet de de dire que $trick en parametre correspond l'id du route

         //   $trick = $trickRepository->findOneBy(["id" => $id]);
           // dd($trick->getUser()->getId());
            $trickFormProfil = $this->createForm(AddTrickFormType::class, $trick);

                 //on traite le formualaire
             $trickFormProfil->handleRequest($request);

            if($trickFormProfil->isSubmitted() && $trickFormProfil->isValid()){
               // dd($trickFormAdmin->getData());
                //on crée le slug à parti du nom de l'astuce
                $slug = strtolower($slugger->slug($trick->getTitle()) );
              //     dd($this->getUser());
                $trick->setUser($trick->getUser());
              //  dd($featuredImage);

              /*
               $featuredImage = $trickFormProfil->get('featureimage')->getData();
              
               $image = $pictureService->square($featuredImage, '/tricks', 200);
                $trick->setFeatureimage($image)   ;

*/

                //dd($slug);
                //on assgine uen valeur au slug de  l'astuce
                $trick->setSlug($slug);
                $trick->setCreatedAt(new \DateTimeImmutable());
                $trick->setUpdatedAt(new \DateTimeImmutable());
                $em->persist($trick);
                $em->flush();

                $this->addFlash('success', 'L\'astuce a été modifiée');
                return $this->redirectToRoute('app_profil_trick_index');
            }
            return $this->render('profil/trick/edit.html.twig', [
                    'trickFormProfil' => $trickFormProfil,
                ]);
        }





        #[IsGranted(new Expression('user === subject.getUser()'), subject: 'trick')]
        #[Route('/show/{id}', name:"show")]
        /**
         * Afficher une astuce (coté profil)
         *
         * @param Trick $trick
         * @return Response
         */
        public function show(Trick $trick): Response{
            
           // dd($trick);
    
           if(!$trick){
            throw $this->createNotFoundException("Cette astuce n'existe pas ");
           }
            return $this->render('profil/trick/show.html.twig', [
                'trick' => $trick,
            ]);
        }





        #[IsGranted(new Expression('user === subject.getUser()'), subject: 'trick')]
        #[Route('/delete/{id}', name:"delete")]
        /**
         * Supprimer une astuce (coté profil)
         *
         * @param Trick $trick
         * @param EntityManagerInterface $em
         * @return Response
         */
       public function delete(Trick $trick, EntityManagerInterface $em):Response{


           if($trick){
               $em->remove($trick);
               $em->flush();
               $this->addFlash('success', 'L\'astuce a été supprimé');
               return $this->redirectToRoute('app_profil_trick_index');
           }else{
               $this->addFlash('warning', 'L\'astuce n a pas été trouvé');
           }


   }



}
