<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;

class UserType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        if($options['ajouter'] == true)
        {

            $builder
            ->add('pseudo', TextType::class, [
                'required' => false,
                'attr' => [
                    'placeholder' => "Joker",
                    'class' => "form-control"
                ],

            ])
            ->add('password', PasswordType::class, [
                'required' => false,
                'attr' => [
                    'class' => "form-control"
                ],
            ])
            ->add('roleUser', ChoiceType::class, [
                'required' => false,
                'attr' => [
                    'class' => "form-control"
                ],
                'choices'  => [
                    'Admin' => 1,
                    'Membre' => 2
                ]
            ])
        ;

        }
        if($options['modifierRole'] == true){
            $builder
            ->add('pseudo', TextType::class, [
                'required' => false,
                'disabled'=> 'disabled',
                'attr' => [
                    'placeholder' => "Joker",
                    'class' => "form-control"
                ],

            ])
            ->add('nom', TextType::class, [
                'required' => false,
                'disabled'=> 'disabled',
                'attr' => [
                    'placeholder' => "ZIADI",
                    'class' => "form-control"
                ],

            ])
            ->add('prenom', TextType::class, [
                'required' => false,
                'disabled'=> 'disabled',
                'attr' => [
                    'placeholder' => "Asmaa",
                    'class' => "form-control"
                ],

            ])
            ->add('telephone', TextType::class, [
                'required' => false,
                'disabled'=> 'disabled',
                'attr' => [
                    'placeholder' => "0610 10 10 10",
                    'class' => "form-control"
                ],

            ])
            ->add('email', EmailType::class, [
                'required' => false,
                'disabled'=> 'disabled',
                'attr' => [
                    'placeholder' => "joker@..",
                    'class' => "form-control"
                ],

            ])
            ->add('civilite', ChoiceType::class, [
                'required' => false,
                'disabled'=> 'disabled',
                'attr' => [
                    'class' => "form-control"
                ],
                'choices'  => [
                    'Homme' => 'Homme',
                    'Femme' => 'Femme',
                    'Autre' => 'Autre',
                ],
            ])
            ->add('roleUser', ChoiceType::class, [
                'required' => false,
                'attr' => [
                    'class' => "form-control"
                ],
                'choices'  => [
                    'Admin' => 1,
                    'Membre' => 2
                ]
            ])
        ;
        }
        if($options['inscription'] == true){
            $builder
            ->add('pseudo', TextType::class, [
                'required' => false,
                'attr' => [
                    'placeholder' => "Joker",
                    'class' => "form-control"
                ],

            ])
            ->add('password', PasswordType::class, [
                'required' => false,
                'attr' => [
                    'class' => "form-control"
                ],

            ])
            ->add('nom', TextType::class, [
                'required' => false,
                'attr' => [
                    'placeholder' => "ZIADI",
                    'class' => "form-control"
                ],

            ])
            ->add('prenom', TextType::class, [
                'required' => false,
                'attr' => [
                    'placeholder' => "Asmaa",
                    'class' => "form-control"
                ],

            ])
            ->add('adresse', TextType::class, [
                'required' => false,
                'attr' => [
                    'placeholder' => "5 ave...",
                    'class' => "form-control"
                ],

            ])
            ->add('cp', TextType::class, [
                'required' => false,
                'attr' => [
                    'placeholder' => "94..",
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
            ->add('telephone', TextType::class, [
                'required' => false,
                'attr' => [
                    'placeholder' => "0610 10 10 10",
                    'class' => "form-control"
                ],

            ])
            ->add('email', EmailType::class, [
                'required' => false,
                'attr' => [
                    'placeholder' => "joker@..",
                    'class' => "form-control"
                ],

            ])
            ->add('civilite', ChoiceType::class, [
                'required' => false,
                'attr' => [
                    'class' => "form-control"
                ],
                'choices'  => [
                    'Homme' => 'Homme',
                    'Femme' => 'Femme',
                    'Autre' => 'Autre',
                ],
            ])
            
        ;
        }
      
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => User::class,
            'ajouter' => false,
            'modifierRole' => false,
            'inscription' => false
        ]);
    }
}
