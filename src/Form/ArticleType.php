<?php

namespace App\Form;

use App\Entity\User;
use App\Entity\Article;
use App\Entity\ArticleCategory;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\UrlType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Security\Core\Security;

class ArticleType extends AbstractType
{
    private $security;

    public function __construct(Security $security)
    {
        $this->security = $security;
    }

    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('title', TextType::class, [
                'attr' => [
                    'placeholder' => 'Par ex. Les féculents font-il grossir ?'
                ],
                'help' => '100 caractères max.',
                'label' => "Titre*"
            ]);

            $user = $this->security->getUser();

            if ($user && in_array('ROLE_ADMIN', $user->getRoles())) {
                $builder->add('user', EntityType::class, [
                    'class' => User::class,
                    'choice_label' => 'email',
                    'label' => "Auteur*",
                    'placeholder' => 'Choisissez un auteur',
                ]);
            };

        $builder   
            ->add('content', TextareaType::class, [
                'label' => "Contenu*",
                'attr' => [
                    'rows' => 6,
                ],
                'help' => '65535 caractères max.'
            ])
            ->add('picture', UrlType::class, [
                'label' => 'URL de l\'image',
                'required' => false,
                'help' => '255 caractères max, une URL en http:// ou https://',
                'default_protocol' => 'https'
            ])
            ->add('publishedAt', DateTimeType::class, [
                'label' => "Publié le*",
                'widget' => 'choice',
                'years' => range(date('Y') - 10, date('Y') + 10),
                'input' => 'datetime_immutable',
                'data' => new \DateTimeImmutable(),
            ])
            ->add('articleCategory', EntityType::class, [
                'class' => ArticleCategory::class,
                'choice_label' => 'label',
                'expanded' => true,
                'multiple' => false,
                'label' => "Catégorie",
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Article::class,
        ]);
    }
}
