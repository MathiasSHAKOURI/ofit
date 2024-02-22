<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\UrlType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class UserType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
        ->add('pseudo', TextType::class, [
            "label" => "Pseudo",
            "attr" => ["placeholder" => "Entrez un pseudo"],
            'help' => '50 caractères max.',
            "required" => false
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
        ->add('picture', UrlType::class, [
            "label" => "URL de l'image",
            "required" => false,
            "attr" => ["placeholder" => "Entrez l'URL de l'image"],
            'help' => '255 caractères max, une URL en http:// ou https://',
            'default_protocol' => 'https'
        ])
        ->add('presentation', TextareaType::class, [
            "label" => "Présentation",
            "attr" => [
                "placeholder" => "Une courte description du coach.",
                "rows" => 6
            ],
            "required" => false,
            'help' => "Si vous remplissez cette partie, il faut au moins 100 caractères jusqu'à 65535 caractères max."
        ]);
        
        if($options["custom_option"] !== "edit")
        {
            $builder
            ->add('password', RepeatedType::class, [
                "type" => PasswordType::class,
                "first_options" => ["label" => "Rentrez un mot de passe", "help" => "Le mot de passe doit contenir à minima 12 caractères, avec 1 majuscule, 1 chiffre et 1 caractères spécial."],
                "second_options" => ["label" => "Confirmez le mot de passe", "help" => "Le mot de passe doit contenir à minima 12 caractères, avec 1 majuscule, 1 chiffre et 1 caractères spécial."],
                "invalid_message" => "Les champs doivent être identiques",
            ]);
        };

}

public function configureOptions(OptionsResolver $resolver): void
{
    $resolver->setDefaults([
        'data_class' => User::class,
        "custom_option" => "default"
    ]);
}
}