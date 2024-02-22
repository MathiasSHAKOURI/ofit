<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Gregwar\CaptchaBundle\Type\CaptchaType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Validator\Constraints\IsTrue;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;

class RegistrationFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('email',EmailType::class,[
                "label" => "Email*",
            ])
            ->add('agreeTerms', CheckboxType::class, [
                'mapped' => false,
                'constraints' => [
                    new IsTrue([
                        'message' => 'You should agree to our terms.',
                    ]),
                ],
            ])
            ->add('password', RepeatedType::class, [
                "type" => PasswordType::class,
                "first_options" => ["label" => "Rentrez un mot de passe*", "help" => "Le mot de passe doit contenir à minima 12 caractères, avec 1 majuscule, 1 chiffre et 1 caractères spécial."],
                "second_options" => ["label" => "Confirmez le mot de passe*", "help" => "Le mot de passe doit contenir à minima 12 caractères, avec 1 majuscule, 1 chiffre et 1 caractères spécial."],
                "invalid_message" => "Les champs doivent être identiques",
            ])
            ->add('firstname', TextType::class, [
                "label" => "Prénom*",
                "attr" => ["placeholder" => "Entrez un prénom"],
                'help' => '100 caractères max.'
            ])
            ->add('lastname', TextType::class, [
                "label" => "Nom*",
                "attr" => ["placeholder" => "Entrez un nom"],
                'help' => '100 caractères max.'
            ])
            ->add('captcha', CaptchaType::class)
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
