<?php

namespace App\Form;

use App\Entity\Categorie;
use App\Entity\Trick;
use App\Form\ColorType;
use App\Repository\CategorieRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\FormType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;

class AddCategorieFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name', TextType::class, [
                'label' => 'Nom de la catégorie ',
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

            //ce champs est un formulaire imbriqué ColorType
            //noublier pas de mettre nul à data class dans ColorType $resolver->setDefaults  'data_class' => null,
            ->add('color', ColorType::class, [
               // 'entry_type' => ColorType::class,
                'label' => 'Choisir la couleur de categorie ',
                'label_attr' =>[
                    'class' => 'form-label mt-4 me-2'
                ],

                'attr' => [
                    'class' => 'm-2 p-1 form-control-color'
                 ],

    
            ])

            ->add('parent', EntityType::class, [
                'class' => Categorie::class,
                'choice_label' => 'name', //un attribut choisi dans Categorie
                'label' => 'Donnez un parent ',
                'placeholder' =>  '-- pas de parent --', //affichage null
                'required' => false ,// non obligatoire,
                'label_attr' =>[
                    'class' => 'form-check-label mt-4'
                ],
                'choice_attr' => function () { return array('class' => 'form-check-input'); },//styliser une option
                             
                 'attr' => [
                    'class' => 'form-select'
                 ],
                    

                //query_builder permet de créer une requete autour d'une champs de type entitytype
                //ex ici :  avec l'aide CategorieRepository on affiche les catégories par ordre ascendat
                'query_builder' => function(CategorieRepository $cr){

                    return $cr->createQueryBuilder('c')
                    ->orderBy("c.name", 'ASC');

                }
            ])

            ->add('submit', SubmitType::class, [
                'label' => 'Créer une catégorie',
                'attr' => [
                    'class' => 'btn btn-primary mt-4'
                ]
            ])

            /*
            ->add('tricks', EntityType::class, [
                'class' => Trick::class,
                'choice_label' => 'id',
                'multiple' => true,
            ])*/
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Categorie::class,
        ]);
    }
}
