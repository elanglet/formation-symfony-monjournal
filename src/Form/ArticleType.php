<?php

namespace App\Form;

use App\Entity\Article;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class ArticleType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add(
                'titre',                            // Nom du champ dans le formulaire. Nom de l'attribut dans l'entité.
                TextType::class,                    // Type de champ. Attention au 'use' à ajouter !!!
                [                                   // Les options du champ
                    'label' => 'Titre : '
                ]
            )
            ->add(
                'texte', TextareaType::class,
                [
                    'label' => 'Texte : '
                ]
            )
            ->add(
                'auteur', TextType::class,
                [
                    'label' => 'Auteur : '
                ]
            )
            ->add(
                'date', DateTimeType::class,
                [
                    'widget' => 'single_text',
                    'label' => 'Date : '
                ]
            )
            // Penser à ajouter le bouton de validation du formulaire
            ->add(
                'submit', SubmitType::class,
                [
                    'label' => 'Enregistrer'
                ]
            )
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Article::class,
        ]);
    }
}
