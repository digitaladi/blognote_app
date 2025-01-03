<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\NotBlank;
use Vich\UploaderBundle\Form\Type\VichImageType;

class EditUserAdminType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('username', TextType::class, [
                'label' => 'Le pseudo',
                'attr' => [
                
                     'class' => 'form-control'
                    
                ],

                'label_attr' =>[
                    'class' => 'form-label mt-4'
                ],

                'constraints' => [
                    new NotBlank()

                ],
                
                ])
            ->add('email', EmailType::class, [
                'label' => 'L\'email',
                'attr' => [
                
                     'class' => 'form-control'
                    
                ],
                'label_attr' =>[
                    'class' => 'form-label mt-4'
                ],
                'constraints' => [
                    new NotBlank()
                ],
            ])


            ->add('imageFile', VichImageType::class, [
                'label' => 'Votre avatar',
                'label_attr' =>[
                 'class' => 'form-label mt-4'
                ],
                'attr'=>[
                    'accept' => 'image/png, image/jpeg, image/webp',
                     'class' => 'form-control'
                  ],
                ])

            ->add('submit', SubmitType::class, [
                'label' => ' Modifier utilisateur',
                'attr' => [
                    'class' => 'btn btn-primary mt-4'
                ]
            ])


        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
