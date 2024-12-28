<?php

namespace App\Form;

use App\Entity\Categorie;
use App\Repository\CategorieRepository;
use Doctrine\ORM\EntityRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class GetTrickByCategorieFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('categorie', EntityType::class, [
                'label' => false, //pas de label
                'class'=> Categorie::class,
                'choice_label' => 'name',
                'multiple'     => false,
                'expanded' => true,
             /*   'query_builder' => function(EntityRepository $er){

                    return $er->createQueryBuilder('c')
                    ->select('c.name')
                    ->getQuery()
                    ->getResult()
                    ;
                },*/
     
               ])

            
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            // Configure your form options here
        ]);
    }
}
