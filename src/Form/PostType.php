<?php

namespace App\Form;

use App\Entity\Post;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class PostType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('title',TextType::class,[
                'attr'=>[
                    'class'=>'form-control',
                    'placeholder'=>'Titulo Post'
                ]
            ])
            ->add('content',TextareaType::class,[
                'attr'=>[
                    'class'=>'form-control',
                    'placeholder'=>'Contenido'
                ]
            ])
            ->add('createdAt',DateTimeType::class)
            ->add('publishedAt',DateTimeType::class)
            ->add('modifiedAt',DateTimeType::class)
            ->add('author',TextType::class,[
                'attr'=>[
                    'class'=>'form-control',
                    'placeholder'=>'Autor'
                ]
            ])
            ->add('user',TextType::class,[
                'attr'=>[
                    'class'=>'form-control',
                    'placeholder'=>'Usuario'
                ]
            ])
            ->add('tags',TextType::class,[
                'attr'=>[
                    'class'=>'form-control',
                    'placeholder'=>'Tags'
                ]
            ])
            ->add('submit',SubmitType::class)
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Post::class,
        ]);
    }
}
