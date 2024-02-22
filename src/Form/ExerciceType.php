<?php

namespace App\Form;

use App\Entity\Exercice;
use App\Entity\MuscularGroup;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\UrlType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;

class ExerciceType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
        ->add('title', TextType::class, [
            'attr' => [
                'placeholder' => "Par ex. Soulevé de terre"
            ],
            'help' => '100 caractères max.',
            'label' => "Titre*"
            ])
            ->add('picture', UrlType::class, [
                'label' => 'URL de l\'image',
                'required' => false,
                'help' => '255 caractères max, une URL en http:// ou https://',
                'default_protocol' => 'https'
            ])
        ->add('description', TextareaType::class, [
            'label' => "Description de l'exercice*",
            'attr' => [
                'rows' => 6,
                'placeholder' => 'Description de l\'exercice'
            ],
            'help' => '65535 caractères max.'
        ])
        ->add('muscularGroup', EntityType::class, [
            'class' => MuscularGroup::class,
            'choice_label' => 'label', 
            'placeholder' => 'Choisis un groupe musculaire',
            'label' => "Groupe musculaire*",
        ]);
}

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Exercice::class,
        ]);
    }
}
