<?php

namespace App\DataFixtures;

use App\Entity\Article;
use App\Entity\ArticleCategory;
use App\Entity\User;
use Faker\Factory;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\String\Slugger\SluggerInterface;
use App\DataFixtures\Provider\OfitProvider;
use App\Entity\Exercice;
use App\Entity\MuscularGroup;
use App\Entity\WorkoutCategory;
use App\Entity\WorkoutParameter;
use App\Entity\WorkoutProgram;
use DateInterval;

class AppFixtures extends Fixture
{
    private $passwordHasher;
    private $slugger;

    public function __construct(UserPasswordHasherInterface $passwordHasher, SluggerInterface $slugger)
    {
        $this->passwordHasher = $passwordHasher;
        $this->slugger = $slugger;
    }

    /**
     * Fonction qui va s'executer quand on va charger les fixtures (envoyer les données en bdd)
     *
     * @param ObjectManager $manager
     * @return void
     */
    public function load(ObjectManager $manager): void
    {
        $faker = Factory::create('fr_FR');
        $provider = new OfitProvider();
        
        $admin = new User();
        $admin
        ->setPseudo("admin")
        ->setFirstname($faker->firstName())
        ->setLastname($faker->lastName())
        ->setEmail("admin@ofit.com")
        ->setPassword($this->passwordHasher->hashPassword($admin, "admin"))
        ->setPicture($faker->imageUrl(mt_rand(300,1000), mt_rand(300, 1500), $admin->getPseudo(), true))
        ->setRoles(["ROLE_ADMIN"])
        ->setPresentation($faker->text())
        ->setIsVerified(true);

        $manager->persist($admin);

        $coachList = [];
        for ($c = 1; $c <= 20; $c++) 
        {
            $coach = new User();
            $coach
            ->setFirstname($faker->firstName())
            ->setLastname($faker->lastName())
            ->setPseudo("Coach ".$coach->getFirstname())
            ->setEmail(\Transliterator::create('NFD; [:Nonspacing Mark:] Remove; NFC')->transliterate(strtolower($coach->getFirstname().".".$coach->getLastname()."@ofit.com")))
            ->setPassword($this->passwordHasher->hashPassword($coach, "coach"))
            // ->setPicture($faker->imageUrl(mt_rand(300,1000), mt_rand(300, 1500),$coach->getPseudo(), true))
            ->setPicture($provider->coachPictures()[$c - 1])
            ->setRoles(["ROLE_COACH"])
            ->setPresentation($faker->text())
            ->setIsVerified(true);

            $coachList[] = $coach;

            $manager->persist($coach);
        };

        $articleCategory = [];

        $articleCategoryHealth = new ArticleCategory();
        $articleCategoryHealth
        ->setLabel("Santé");
        $articleCategory[] = $articleCategoryHealth;
        $healthPicture = $provider->healthPictures();
        $healthTitle = $provider->healthTitles();
        $manager->persist($articleCategoryHealth);

        $articleCategoryNutrition = new ArticleCategory();
        $articleCategoryNutrition
        ->setLabel("Nutrition");
        $articleCategory[] = $articleCategoryNutrition;
        $nutritionPictures = $provider->nutritionPictures();
        $nutritionTitles = $provider->nutritionTitles();
        $manager->persist($articleCategoryNutrition);

        $articleCategorySport = new ArticleCategory();
        $articleCategorySport
        ->setLabel("Sport");
        $articleCategory[] = $articleCategorySport;
        $sportPictures = $provider->sportPictures();
        $sportTitles = $provider->sportTitles();
        $manager->persist($articleCategorySport);

        $usedTitles = [];
        for ($a = 1; $a <= 100; $a++)
        {
            $category = $articleCategory[array_rand($articleCategory)];

            if ($category->getLabel() === "Santé")
            {
                $picture = $healthPicture[array_rand($healthPicture)];

                do {
                    $title = $healthTitle[array_rand($healthTitle)];
                } while (in_array($title, $usedTitles));

                $usedTitles[] = $title;
            }
            else if ($category->getLabel() === "Nutrition")
            {
                $picture = $nutritionPictures[array_rand($nutritionPictures)];

                do {
                    $title = $nutritionTitles[array_rand($nutritionTitles)];
                } while (in_array($title, $usedTitles));

                $usedTitles[] = $title;
            }
            else if ($category->getLabel() === "Sport")
            {
                $picture = $sportPictures[array_rand($sportPictures)];

                do {
                    $title = $sportTitles[array_rand($sportTitles)];
                } while (in_array($title, $usedTitles));

                $usedTitles[] = $title;
            };

            $beforeOrAfter = mt_rand(0,2);
            if ($beforeOrAfter === 0)
            {
                $createdAt = \DateTimeImmutable::createFromMutable($faker->dateTimeBetween('now','+1 years'));
            }
            else
            {
                $createdAt = \DateTimeImmutable::createFromMutable($faker->dateTimeBetween('-5 years'));
            };

            $publishedAt = $createdAt->add(new DateInterval('P5W'));
            $article = new Article();
            $article
            // ->setTitle($faker->sentence())
            ->setTitle($title)
            // ->setPicture($faker->imageUrl(mt_rand(300,1000), mt_rand(300, 1500), $category->getLabel(), true))
            ->setPicture($picture)
            ->setContent($faker->text(5000))
            ->setSlug(strtolower($this->slugger->slug($article->getTitle())))
            ->setCreatedAt($createdAt)
            ->setUser($coachList[array_rand($coachList)])
            ->setArticleCategory($category)
            ->setPublishedAt($publishedAt);

            $manager->persist($article);
        };

        $workoutGroupsList = $provider->exercices();
        $exercicesForProgram = [];
        foreach ($workoutGroupsList as $muscularGroup => $exercices)
        {
            $workoutGroup = new MuscularGroup();
            $workoutGroup
            ->setLabel($muscularGroup)
            ->setPicture($faker->imageUrl(mt_rand(300,1000), mt_rand(300, 1500), $muscularGroup, true))
            ->setSlug(strtolower($this->slugger->slug($workoutGroup->getLabel())));
            $manager->persist($workoutGroup);

            foreach ($exercices as $exercice)
            {
                $groupExercice = new Exercice();
                $groupExercice
                ->setTitle($exercice)
                // ->setPicture($faker->imageUrl(mt_rand(300,1000), mt_rand(300, 1500), $exercice, true))
                ->setPicture($provider->exercicePictures()[array_rand($provider->exercicePictures())])
                ->setSlug(strtolower($this->slugger->slug($groupExercice->getTitle())))
                ->setMuscularGroup($workoutGroup)
                ->setDescription($faker->text(5000));
                $exercicesForProgram[] = $groupExercice;
                $manager->persist($groupExercice);
            };
        };

        $workoutCategories = $provider->workoutCategories();
        $workoutCategoriesForProgram = [];
        foreach ($workoutCategories as $workoutCategory)
        {
            $workoutCat = new WorkoutCategory();
            $workoutCat
            ->setLabel($workoutCategory);
            $workoutCategoriesForProgram[] = $workoutCat;
            $manager->persist($workoutCat);
        };

        $workoutPrograms = $provider->workoutPrograms();
        foreach ($workoutPrograms as $workoutProgram)
        {
            $restBetween = [60,90,120,150,180,210,240,270,300];

            $beforeOrAfter = mt_rand(0,2);
            if ($beforeOrAfter === 0)
            {
                $createdAt = \DateTimeImmutable::createFromMutable($faker->dateTimeBetween('now','+1 years'));
            }
            else
            {
                $createdAt = \DateTimeImmutable::createFromMutable($faker->dateTimeBetween('-5 years'));
            };

            $publishedAt = $createdAt->add(new DateInterval('P5W'));
            $workoutProg = new WorkoutProgram();
            $workoutProg
            ->setTitle($workoutProgram)
            // ->setPicture($faker->imageUrl(mt_rand(300,1000), mt_rand(300, 1500), $workoutProgram, true))
            ->setPicture($provider->programPictures()[array_rand($provider->programPictures())])
            ->setDescription($faker->text(1000))
            // ->setDuration(mt_rand(20,60))
            ->setWorkoutCategory($workoutCategoriesForProgram[array_rand($workoutCategoriesForProgram)])
            ->setUser($coachList[array_rand($coachList)])
            ->setCreatedAt($createdAt)
            ->setPublishedAt($publishedAt)
            ->setSlug(strtolower($this->slugger->slug($workoutProg->getTitle())))
            ->setRestBetween($restBetween[array_rand($restBetween)]);
            $manager->persist($workoutProg);

            $usedExercices = [];
            for ($workoutParam = 1; $workoutParam <= mt_rand(4,10); $workoutParam++)
            {   
                $restAndDurationArray = [15,30,45,60,90];
                $repsArray = [8,10,12,14,16];

                $workoutParameter = new WorkoutParameter();

                do {
                    $randomExercise = $exercicesForProgram[array_rand($exercicesForProgram)];
                } while (in_array($randomExercise, $usedExercices));

                $usedExercises[] = $randomExercise;

                $workoutParameter
                ->setSets(mt_rand(3,5))
                ->setRest($restAndDurationArray[array_rand($restAndDurationArray)])
                ->setExercice($randomExercise)
                ->setWorkoutProgram($workoutProg);
                $repsOrDuration = mt_rand(0,1);
                if ($repsOrDuration === 1)
                {$workoutParameter->setReps($repsArray[array_rand($repsArray)]);}
                else
                {$workoutParameter->setDuration($restAndDurationArray[array_rand($restAndDurationArray)]);};
                
                $manager->persist($workoutParameter);
            };
        };
        $manager->flush();
    }
}