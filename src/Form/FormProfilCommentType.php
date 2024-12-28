<?php

namespace App\Form;

use App\Entity\User;
use App\Entity\Trick;
use App\Entity\Comment;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;

class FormProfilCommentType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('content', TextareaType::class, [
                'label' => 'Commentaire : ',

                'label_attr' =>[
                    'class' => 'form-label'
                ],
                'attr' => [
                    'class' => 'form-control',
                    "rows" => 4
                ],
            ])
            
            ->add('submit', SubmitType::class, [
                'label' => 'Poster le commentaire',
                'attr' => [
                    'class' => 'btn btn-primary mt-2 float-end mb-2'
                ]
            ])
            //form_profil_comment_comment_id
            ->add('comment_id', HiddenType::class, [
                'mapped' => false
            ])


         //   ->add('isReply')

/*
            ->add('createAt', null, [
                'widget' => 'single_text',
            ])
            ->add('updateAt', null, [
                'widget' => 'single_text',
            ])

            */
/*
            ->add('comment', EntityType::class, [
                'class' => Comment::class,
                'choice_label' => 'id',
            ])
*/

            /*
            ->add('user', EntityType::class, [
                'class' => User::class,
                'choice_label' => 'id',
            ])
            ->add('trick', EntityType::class, [
                'class' => Trick::class,
                'choice_label' => 'id',
            ])

            */
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Comment::class,
        ]);
    }
}
