<?php

namespace App\Form;

use App\Entity\Photo;
use App\Entity\Annonce;
use App\Form\PhotoType;
use App\Entity\Categorie;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Validator\Constraints\File;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;

class AnnonceType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        if($options['ajouter'] == true)
        {
            $builder
            ->add('titre', TextType::class, [
                'required' => false,
                'attr' => [
                    'placeholder' => "Titre de l'annonce",
                ],

            ])
            ->add('description_courte', TextareaType::class, [
                'required' => false,
                'attr' => [
                    'placeholder' => "Description courte de votre annonce",
                ],

            ])
            ->add('description_longue', TextareaType::class, [
                'required' => false,
                'attr' => [
                    'placeholder' => "Description longue de votre annonce",
                ],

            ])
            // ->add('imageFile', FileType::class, [
            //     "required" => false,
            //     'mapped' => false,
            //     'constraints' => [
            //         new File([
            //                 'mimeTypes' => [
            //                     "image/png",
            //                     "image/jpg",
            //                     "image/jpeg",

            //                 ],
            //                 'mimeTypesMessage' => "Extensions Autorisées : PNG JPG JPEG"
            //             ])
            //     ]

            // ])
            ->add('prix', NumberType::class, [
                'required' => false,
                'attr' => [
                    'placeholder' => "Saisir le prix",
                    'invalid_message'=> "le prixdoit être un nombre"

                ],
            ])
            ->add('adresse', TextareaType::class, [
                'required' => false,
                'attr' => [
                    'placeholder' => "Adresse figurant dans l'annonce",
                ],

            ])
            ->add('cp', TextType::class, [
                'required' => false,
                'label' => "Code Postal",
                'attr' => [
                    'placeholder' => "Code Postal figurant dans l'annonce",
                ],

            ])
            ->add('ville', TextType::class, [
                'required' => false,
                'attr' => [
                    'placeholder' => "Paris",
                ],

            ])

            ->add('categorie', EntityType::class, [  
                "class" => Categorie::class,         
                "choice_label" => "titre",            

            ])
        ;
        }
        elseif($options['modifier'] == true)
        {
            $builder
            ->add('titre', TextType::class, [
                'required' => false,
                'attr' => [
                    'placeholder' => "Titre de l'annonce",
                ],

            ])
            ->add('description_courte', TextareaType::class, [
                'required' => false,
                'attr' => [
                    'placeholder' => "Description courte de votre annonce",
                ],

            ])
            ->add('description_longue', TextareaType::class, [
                'required' => false,
                'attr' => [
                    'placeholder' => "Description longue de votre annonce",
                ],

            ])
            ->add('prix', NumberType::class, [
                'required' => false,
                'attr' => [
                    'placeholder' => "Saisir le prix",
                    'invalid_message'=> "le prixdoit être un nombre"

                ],
            ])
            ->add('adresse', TextareaType::class, [
                'required' => false,
                'attr' => [
                    'placeholder' => "Adresse figurant dans l'annonce",
                ],

            ])
            ->add('cp', TextType::class, [
                'required' => false,
                'label' => "Code Postal",
                'attr' => [
                    'placeholder' => "Code Postal figurant dans l'annonce",
                ],

            ])
            ->add('ville', TextType::class, [
                'required' => false,
                'attr' => [
                    'placeholder' => "Paris",
                ],

            ])

            ->add('categorie', EntityType::class, [  
                "class" => Categorie::class,         
                "choice_label" => "titre",            

            ])
        ;
        }
        elseif($options['add'] == true)
        {
            $builder
            ->add('titre', TextType::class, [
                'required' => false,
                'attr' => [
                    'placeholder' => "Titre de l'annonce",
                    'class' => "form-control"
                ],

            ])
            ->add('description_courte', TextareaType::class, [
                'required' => false,
                'attr' => [
                    'placeholder' => "Description courte de votre annonce",
                    'class' => "form-control"
                ],

            ])
            ->add('description_longue', TextareaType::class, [
                'required' => false,
                'attr' => [
                    'placeholder' => "Description longue de votre annonce",
                    'class' => "form-control"
                ],

            ])
            ->add('prix', NumberType::class, [
                'required' => false,
                'attr' => [
                    'placeholder' => "Saisir le prix",
                    'invalid_message'=> "le prixdoit être un nombre",
                    'class' => "form-control"

                ],
            ])
            ->add('adresse', TextareaType::class, [
                'required' => false,
                'attr' => [
                    'placeholder' => "Adresse figurant dans l'annonce",
                    'class' => "form-control"
                ],

            ])
            ->add('cp', TextType::class, [
                'required' => false,
                'label' => "Code Postal",
                'attr' => [
                    'placeholder' => "Code Postal figurant dans l'annonce",
                    'class' => "form-control"
                ],

            ])
            ->add('ville', TextType::class, [
                'required' => false,
                'attr' => [
                    'placeholder' => "Paris",
                    'class' => "form-control"
                ],

            ])

            ->add('categorie', EntityType::class, [  
                "class" => Categorie::class,         
                "choice_label" => "titre",    
                'attr' => [
                    'placeholder' => "Paris",
                    'class' => "form-control"
                ],        

            ])
        //     ->add('photos', CollectionType::class, [
        //         "required" => false,
        //         'attr' => [
        //             'placeholder' => "Image du produit",
        //             'class' => "form-control"

        //         ],
        //         'entry_type' => FileType::class,
        //         'entry_options' => [
        //             'attr' => ['class' => 'email-box'],
        //         ],
        //         'allow_add' => true,
        //         'allow_delete' => true,
        //         'constraints' => [
        //             new File([
        //                 'mimeTypes' => [
        //                     "image/png",
        //                     "image/jpg",
        //                     "image/jpeg",

        //                 ],
        //                 'mimeTypesMessage' => "Extensions Autorisées : PNG JPG JPEG"
        //             ])
        //     ]
        ->add('photos', FileType::class, [
            "mapped" => false,
            "required" => false,
            'label' => false,
            "multiple" => true,
            'attr' => [
                'placeholder' => "Image du produit",
                'class' => "form-control"

            ],

    ])

        // ])
        // ->add('photos', EntityType::class, [
        //     "class" => Photo::class,
        //     "multiple" => true,
        //     "choice_label" => "nom",
        //     "expanded" => true,
        //     "attr" =>[
        //         'class' => "file"],      
           
        // ])

        ;
        }
        
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Annonce::class,
            'ajouter' => false,
            'modifier' => false,
            'add' => false
        ]);
    }
}
