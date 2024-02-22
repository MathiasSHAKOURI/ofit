<?php

namespace App\Form;

use App\Entity\Exercice;
use Doctrine\ORM\QueryBuilder;
use App\Entity\WorkoutParameter;
use Doctrine\ORM\EntityRepository;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType as TypeIntegerType;

class WorkoutParameterType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
        ->add('exercice', EntityType::class, [
            'class' => Exercice::class,
            'query_builder' => function (EntityRepository $er): QueryBuilder {
                return $er->createQueryBuilder('e')
                    ->orderBy('e.title', 'ASC');
            },
            'label' => 'Exercice*',
            'choice_label' => 'title',
            'placeholder' => 'Choisissez un exercice à ajouter au programme'
        ])
        ->add('reps', ChoiceType::class, [
            'label' => 'Nombre de répétitions',
            'placeholder' => 'Choisisez le nombre de répétitions de l\'exercice',
            'choices' => array_combine(WorkoutParameter::REPS,WorkoutParameter::REPS),
            'invalid_message' => "Veuillez choisir un nombre de répétitions valide.",
            'help' => 'Veuillez choisir soit un nombre de répétitions, soit une durée.',
            'required' => false
        ])
        ->add('duration', ChoiceType::class, [
            'label' => 'Durée de l\'exercice (en secondes)',
            'placeholder' => 'Choisissez la durée de l\'exercice',
            'choices' => array_combine(WorkoutParameter::DURATION,WorkoutParameter::DURATION),
            'invalid_message' => "Veuillez choisir une durée valide.",
            'help' => 'Veuillez choisir soit un nombre de répétitions, soit une durée.',
            'required' => false
        ])
        ->add('sets', TypeIntegerType::class, [
            'attr' => [
                'placeholder' => 'Veuillez choisir un nombre de série.',
                'min' => 1,
                'max' => 20
            ],
            'label' => "Nombre de série*",
            'invalid_message' => "Veuillez choisir nombre de série valide.",
            'help' => 'Compris entre 1 et 20.'
            
        ])
        ->add('rest', ChoiceType::class, [
            'label' => "Durée de repos entre chaque série (en secondes)*",
            'placeholder' => 'Choisisez le temps de repos entre chaque série',
            'choices' => array_combine(WorkoutParameter::REST,WorkoutParameter::REST),
            'invalid_message' => "Veuillez choisir une durée de repos valide.",
        ]);
}

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => WorkoutParameter::class,
        ]);
    }
}
