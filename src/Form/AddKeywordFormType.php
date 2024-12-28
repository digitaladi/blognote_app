<?php

namespace App\Form;

use App\Entity\Keyword;
use App\Entity\Trick;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\NotBlank;

class AddKeywordFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name', TextType::class, [
                'label' => "Le nom du mot clé",
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


            /*
            ->add('slug', TextType::class, [
                'label' => "Le slug du mot clé",
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
*/
            ->add('submit', SubmitType::class, [
                'label' => 'Créer un mot clé',
                'attr' => [
                    'class' => 'btn btn-primary mt-4'
                ]
            ])


      /*      ->add('tricks', EntityType::class, [
                'class' => Trick::class,
                'choice_label' => 'id',
                'multiple' => true,
            ])*/
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Keyword::class,
        ]);
    }
}
