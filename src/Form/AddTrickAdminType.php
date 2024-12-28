<?php

namespace App\Form;

use App\Entity\Categorie;
use App\Entity\Keyword;
use App\Entity\Trick;
use App\Entity\User;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\Image;
use Vich\UploaderBundle\Form\Type\VichImageType;

class AddTrickAdminType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('title', TextType::class, [
                'label' => 'Titre de l\'astuce',
                'label_attr' =>[
                    'class' => 'form-label mt-4'
                ],
                'constraints' => [
                    new NotBlank()
                ],
                'attr' => [
                    'class' => 'form-control'
                ]

            ])
         
            ->add('content', TextareaType::class, [
                'label' => 'Le descriptif de l\'astuce',
                'label_attr' =>[
                    'class' => 'form-label mt-4'
                ],
                'attr' => [
                    'class' => 'form-control'
                ]
            ])
            ->add('imageFile', VichImageType::class, [
                'label' => 'Image d\'illustration',
               // "mapped" => false,
                'label_attr' =>[
                 'class' => 'form-label mt-4'
                ],
                'attr'=>[
                    'accept' => 'image/png, image/jpeg, image/webp',
                     'class' => 'form-control'
                  ],
                ])

/*
            ->add('user', EntityType::class, [
                'class' => User::class,
                'choice_label' => 'id',
            ])

  */

            ->add('public', CheckboxType::class, [
                'label' => 'Voulez vous rendre public l\'astuce ?',
                'attr' => [
                    'class' => 'form-check-input mt-4'
                ],
                    
                'label_attr' =>[
                    'class' => 'form-check-label mt-4 me-1'
                ],
            ])

            ->add('categorie', EntityType::class, [
                'class' => Categorie::class,
                
                'choice_label' => 'name',
                'choice_attr' => function () { return array('class' => 'form-check-input'); },//styliser une option
               // 'multiple' => true, //on peut choisir plusieurs
                 //'expanded' => true, // case à cocher
                 'label' => 'La catégorie de l\'astuce',
                 'label_attr' =>[
                     'class' => 'form-check-label mt-4 mb-1'
                 ],
                 
                 'attr' => [
                    'class' => 'form-select'
                ]
                    
            ])


          
            ->add('keyword', EntityType::class, [
                'label' => 'Mot clé de l\'astuce',
                'label_attr' =>[
                    'class' => 'form-check-label mt-4  mb-1'
                ],
                'choice_attr' => function () { return array('class' => 'form-check-input'); },//styliser une option
                                 
                 'attr' => [
                    'class' => 'form-select'
                 ],
                    

                'class' => Keyword::class,  
                'choice_label' => 'name',
                //'multiple' => true,
                //'expanded' => true, // case à cocher
            ])

            ->add('submit', SubmitType::class, [
                'label' => 'Créer une astuce',
                'attr' => [
                    'class' => 'btn btn-primary mt-4'
                ]
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Trick::class,
        ]);
    }
}
