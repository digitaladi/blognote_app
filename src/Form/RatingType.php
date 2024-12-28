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

class RatingType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
        ->add('note', RangeType::class, [
            'label' => "Choisissez entre  0 a 5",
            'attr' => [
                'min' => 0,
                'max' => 5,
                'step' => 1,
                'value'=> 0,
                'class' => 'form-range'
            ],
           
        ])


        ->add('submit', SubmitType::class, [
            'label' => 'Confirmer',
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
