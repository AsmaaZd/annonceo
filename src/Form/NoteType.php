<?php

namespace App\Form;

use App\Entity\Note;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;

class NoteType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('note', NumberType::class, [
                'required' => false,
                'label' => false,
                'attr' => [
                    'placeholder' => "Note sur 5",
                    'class' => "form-control"
                ],

            ])
            ->add('avis', TextType::class, [
                'required' => false,
                'label' => false,
                'attr' => [
                    'placeholder' => "Bonjour...",
                    'class' => "form-control"
                ],

            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Note::class,
        ]);
    }
}
