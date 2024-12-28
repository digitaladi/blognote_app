<?php

namespace App\Form;

use App\Entity\Comment;
use App\Entity\Trick;
use App\Entity\User;
use Doctrine\DBAL\Types\BooleanType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class AddCommentAdminType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
           ->add('content', TextareaType::class, [
            'label' => "Commentaire",
            'label_attr' =>[
                'class' => 'form-label mt-4'
            ],
            'attr' => [
                'class' => 'form-control'
            ]
           ])
            
           ->add('isReply', null, [
            'label' => "  As t'il une réponse",
           // 'mapped' => true //ne doit pas etre pris en compte par le mappage de l'entité comment
           'label_attr' =>[
            'class' => 'form-check-label mt-3'
        ],
        'attr' => [
           'class' => 'form-check-input ms-1 mt-3' 
        ],
           ])

           
          /*
            ->add('comment', EntityType::class, [
                'class' => Comment::class,
                'choice_label' => 'content',
            ])
*/
            
            ->add('user', EntityType::class, [
                'label' => "L'utilisateur du commentaire",
                'class' => User::class,
                'choice_label' => 'username',
                'placeholder' =>  '-- Choisir un utilisateur du commentaire --', //affichage null
                'choice_attr' => function () { return array('class' => 'form-check-input'); },//styliser une option
                'label_attr' =>[
                    'class' => 'form-check-label mt-4 mb-1'
                ],              
                'attr' => [
                   'class' => 'form-select'
                ],
                
            ])
            ->add('trick', EntityType::class, [
                'label' => "L'astuce du commentaire",
                'placeholder' =>  '-- Choisir un astuce du commentaire --', //affichage null
                'label_attr' =>[
                    'class' => 'form-check-label mt-4 mb-1'
                ],
                'class' => Trick::class,
                'choice_label' => 'title',
                'choice_attr' => function () { return array('class' => 'form-check-input'); },//styliser une option
                             
                'attr' => [
                   'class' => 'form-select'
                ],
            ])

            ->add('submit', SubmitType::class, [
                'label' => 'Créer un commantaire',
                'attr' => [
                    'class' => 'btn btn-primary mt-4'
                ]
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Comment::class,
        ]);
    }
}
