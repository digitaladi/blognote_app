<?php

namespace App\Form;

use App\Entity\Contact;
use Karser\Recaptcha3Bundle\Form\Recaptcha3Type;
use Karser\Recaptcha3Bundle\Validator\Constraints\Recaptcha3;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Email;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;

class ContactType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
        ->add('pseudo', TextType::class, [
            'label' => 'Le pseudo',
            'attr' => [
            
                 'class' => 'form-control'
                
            ],

            'label_attr' =>[
                'class' => 'form-label mt-4'
            ],


            
            ])
            ->add('email', EmailType::class, [
                'label' => 'L\'email',
                'attr' => [
                    'minlenght' => '2',
                    'maxlenght' => '180',
                     'class' => 'form-control'
                    
                ],
                'label_attr' =>[
                    'class' => 'form-label mt-4'
                ],
                'constraints' => [
                    new NotBlank(),
                    new Email(),
                    new Length(['min' => 2, 'max' => 180])
                ],
            ])
            ->add('subject', TextType::class,[
                'label' => 'Le sujet',
                'attr' => [
                     'minlenght' => '2',
                     'maxlenght' => '50',
                     'class' => 'form-control'
                    
                ],
    
                'label_attr' =>[
                    'class' => 'form-label mt-4'
                ],

                'constraints' => [

                    new Length(['min' => 2, 'max' => 100])
                ],
    
    
                
                ])
                ->add('message', TextareaType::class, [
                    'label' => 'Le message',
                    'label_attr' =>[
                        'class' => 'form-label mt-4'
                    ],
                    'attr' => [
                        'class' => 'form-control'
                    ],

                    'constraints' => [
                        new NotBlank(),

                    ],
                ])

                ->add('submit', SubmitType::class, [
                    'label' => 'Envoyer',
                    'attr' => [
                        'class' => 'btn btn-primary mt-4'
                    ]
                ])

                //ce champs permet de gerer le recaptcha    
                ->add('captcha', Recaptcha3Type::class, [
                    'constraints' => new Recaptcha3(),
                    'action_name' => 'contact',
                
                    'locale' => 'fr',
                ])
 
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Contact::class,
        ]);
    }
}
