<?php

namespace App\Form;

use App\Entity\Rating;
use App\Entity\Trick;
use App\Entity\User;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\RangeType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class AddRatingAdminType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('note', RangeType::class, [
                'label' => "Noter de 0 a 5",
                'attr' => [
                    'min' => 0,
                    'max' => 5,
                    'step' => 1,
                    'value'=> 0,
                    'class' => 'form-range'
                ],
               
            ])
            ->add('trick', EntityType::class, [
                'label' => "L' astuce du note",
                'class' => Trick::class,
                'choice_label' => 'title',
                'label_attr' =>[
                    'class' => 'form-check-label mt-4 mb-1'
                ],              
                'attr' => [
                   'class' => 'form-select'
                ],
                'label_attr' =>[
                    'class' => 'form-label mt-4 mb-1'
                ], 
            ])
            ->add('user', EntityType::class, [
                'label' => "L' auteur du note",
                'class' => User::class,
                'choice_label' => 'username',
                'label_attr' =>[
                    'class' => 'form-label mt-4 mb-1'
                ],              
                'attr' => [
                   'class' => 'form-select'
                ],
            ])


            ->add('submit', SubmitType::class, [
                'label' => 'Noter l\'astuce',
                'attr' => [
                    'class' => 'btn btn-primary mt-4'
                ]
            ])

        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Rating::class,
        ]);
    }
}
