<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\IsTrue;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\PasswordStrength;
use Vich\UploaderBundle\Form\Type\VichFileType;
use Vich\UploaderBundle\Form\Type\VichImageType;

class RegistrationFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('username', TextType::class, [
                'label' => 'Le pseudo',
                'attr' => [
                    'placeholder' => 'Le pseudo',
                         'class' => 'form-control'

                ],
                'label_attr' =>[
                    'class' => 'form-label mt-4'
                ],
            ])
            ->add('email', EmailType::class, [
                'label' => 'L\'email',
                'attr' =>[
                         'placeholder' => 'L\'email',
                         'class' => 'form-control'
                ],
                'label_attr' =>[
                    'class' => 'form-label mt-4'
                ],
            ])

            



            ->add('password', RepeatedType::class, [
                'type' => PasswordType::class,
                'invalid_message' => 'Les mots de passe ne correspondent pas.',
                'options' => ['attr' => ['class' => 'password-field']],
                'required' => true,
                'first_options'  => [
                    'label' => 'Mot de passe',
                    'attr' => [
                        'autocomplete' => 'new-password',
                          'placeholder' => 'mot de passe',
                             'class' => 'form-control'
                    ],
                    'label_attr' =>[
                        'class' => 'form-label mt-4'
                    ],
                    
                ],
                'second_options' => [
                    'label' => 'Confirmation de mot de passe',
                    'attr' => [
                        
                          'placeholder' => 'Confirmation de mot de passe',
                             'class' => 'form-control'
                    ],
                    'label_attr' =>[
                        'class' => 'form-label mt-4'
                    ],
                ],
            ])


/*

            ->add('plainPassword', PasswordType::class, [
                'label' => 'Mot de passe',
                // instead of being set onto the object directly,
                // this is read and encoded in the controller
                'mapped' => false,
                'attr' => [
                    'autocomplete' => 'new-password',
                      'placeholder' => 'mot de passe',
                         'class' => 'form-control'
                ],

                'label_attr' =>[
                    'class' => 'form-label mt-4'
                ],
                'constraints' => [
                    new NotBlank([
                        'message' => 'Veuillez renter votre mot de passe',
                    ]),
                    new Length([
                       // 'min' => 6,
                        'minMessage' => 'Your password should be at least {{ limit }} characters',
                        // max length allowed by Symfony for security reasons
                        'max' => 4096,
                    ]),


                    

                    //un mot de passe très fort

                    /*
                    new PasswordStrength(
                        minScore: PasswordStrength::STRENGTH_STRONG
                        //PasswordStrength::STRENGTH_WEAK = 1
                        //PasswordStrength::STRENGTH_MEDIUM = 2
                        //PasswordStrength::STRENGTH_STRONG = 3
                        //PasswordStrength::STRENGTH_VERY_STRONG = 4
                    )
                       
                ],
            ])

 */


                    ->add('imageFile', VichImageType::class, [
                        'label' => 'Votre avatar',
                       // "mapped" => false,
                        'label_attr' =>[
                         'class' => 'form-label mt-4'
                        ],
                        'attr'=>[
                            'accept' => 'image/png, image/jpeg, image/webp',
                             'class' => 'form-control'
                          ],
                        ])

            ->add('agreeTerms', CheckboxType::class, [
                'label' => 'Accepter les conditions',
                'label_attr' =>[
                    'class' => 'form-check-label mt-4'
                ],
                'attr' => [
                   'class' => 'form-check-input ms-1 mt-4' 
                ],
      
                'mapped' => false, //ne doit pas etre pris en compte par le mappage de l'entité user
                'constraints' => [
                    new IsTrue([
                        'message' => 'You should agree to our terms.',
                    ]),
                ],
            ])



            ->add('submit', SubmitType::class, [
                'label' => ' S\'inscrire',
                'attr' => [
                    'class' => 'btn btn-primary mt-4',
                    'id' => 'submit-button'
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
