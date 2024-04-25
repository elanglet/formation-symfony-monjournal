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

use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\Length;

class ArticleType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add(
                'titre',                            // Nom du champ dans le formulaire. Nom de l'attribut dans l'entité.
                TextType::class,                    // Type de champ. Attention au 'use' à ajouter !!!
                [                                   // Les options du champ
                    'label' => 'Titre : ',
                    'constraints' => [                                        // Définition des contraintes de validation
                        new NotBlank(                                         // Attention au 'use Symfony\Component\Validator\Constraints\NotBlank;'
                            ['message' => "Le titre est obligatoire !"]       // option 'message' pour la validation
                        ),
                        new Length(
                            [
                                'min' => 5,
                                'max' => 200,
                                'minMessage' => "Le titre doit faire au moins 5 caractères.",
                                'maxMessage' => "Le titre ne doit pas dépasser 200 caractères.",
                            ]    
                        )    
                    ]
                ]
            )
            ->add(
                'texte', TextareaType::class,
                [
                    'label' => 'Texte : ',
                    'constraints' => [
                        new NotBlank(                                         
                            ['message' => "Le texte est obligatoire !"]       
                        ),
                    ]
                ]
            )
            ->add(
                'auteur', TextType::class,
                [
                    'label' => 'Auteur : ',
                    'constraints' => [                                         // Définition des contraintes de validation
                        new NotBlank(                                          // Attention au 'use Symfony\Component\Validator\Constraints\NotBlank;'
                            ['message' => "L'auteur est obligatoire !"]       // option 'message' pour la validation
                        ),
                        new Length(
                            [
                                'min' => 3,
                                'max' => 50,
                                'minMessage' => "Le nom d'auteur doit faire au moins 3 caractères.",
                                'maxMessage' => "Le nom d'auteur ne doit pas dépasser 50 caractères.",
                            ]    
                        )    
                    ]
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
