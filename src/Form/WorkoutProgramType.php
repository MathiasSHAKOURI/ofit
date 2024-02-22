<?php

namespace App\Form;

use App\Entity\User;
use App\Entity\WorkoutProgram;
use App\Entity\WorkoutCategory;
use App\Form\WorkoutParameterType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Security\Core\Security;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\UrlType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;

class WorkoutProgramType extends AbstractType
{
    private $security;

    public function __construct(Security $security)
    {
        $this->security = $security;
    }

    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $user = $this->security->getUser();

        if ($user && in_array('ROLE_ADMIN', $user->getRoles())) {
            $builder
            ->add('user', EntityType::class, [
                'class' => User::class,
                'choice_label' => 'username',
                'placeholder' => 'Choisissez un Coach',
        ]);
        };

        $builder
        ->add('title', TextType::class, [
            'attr' => [
                'placeholder' => 'Entrez le titre du programme'
            ],
            'help' => '100 caractères max.',
            'label' => "Titre*"
        ])
        ->add('picture', UrlType::class, [
            'label' => 'URL de l\'image',
            'required' => false,
            'help' => '255 caractères max.',
            'default_protocol' => 'https'
        ])
        ->add('description', TextareaType::class, [
            'attr' => [
                'placeholder' => 'Ajoutez une description',
                'rows' => 6,
            ],
            'help' => '65535 caractères max.',
            'label' => "Description*"
        ])
        ->add('workoutCategory', EntityType::class, [
            'class' => WorkoutCategory::class,
            'choice_label' => 'label',
            'placeholder' => 'Choisissez une catégorie de programme',
            'label' => 'Catégorie*'
        ])

        ->add('publishedAt', DateTimeType::class, [
            'label' => "Publié le*",
            'widget' => 'choice',
            'years' => range(date('Y') - 10, date('Y') + 10),
            'input' => 'datetime_immutable',
            'data' => new \DateTimeImmutable(),
        ])
        ->add('restBetween', ChoiceType::class, [
            'label' => 'Temps de repos entre exercices (en secondes)*',
            'choices' => array_combine(WorkoutProgram::RESTBETWEEN, WorkoutProgram::RESTBETWEEN),
            'invalid_message' => "Veuillez choisir un temps de repos valide.",
            'placeholder' => 'Choisissez le temps de repos entre exercices',
        ])
        ->add('workoutParameters', CollectionType::class, [
            'entry_type' => WorkoutParameterType::class,
            'allow_add' => true,
            'by_reference' => false,
            'entry_options' => ['label' => false],
            'allow_delete' => true,
            'label' => ' '
        ]);
}

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => WorkoutProgram::class,
        ]);
    }
}
