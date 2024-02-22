<?php

namespace App\Controller\Front;

use App\Entity\User;
use App\Entity\Article;
use App\Repository\UserRepository;
use App\Repository\ArticleRepository;
use App\Repository\WorkoutProgramRepository;
use App\Repository\ArticleCategoryRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class CoachController extends AbstractController
{
    /**
     * @Route("/coachs", name="app_coach")
     */
    public function index(Request $request, UserRepository $userRepository): Response
    {
        return $this->render('front/coach/index.html.twig', [
        ]);
    }

    /**
     * @Route("/coach/{id}/{firstname}", name="app_coach_show")
     */
    public function show(User $user, ArticleRepository $articleRepository, ArticleCategoryRepository $articleCategoryRepository, WorkoutProgramRepository $workoutProgramRepository)
    {
        return $this->render('front/coach/show.html.twig', [
            'coach' => $user,
            'articlesNutrition' => $articleRepository->findBy(['user' => $user->getId(), 'articleCategory' => $articleCategoryRepository->findBy(['label' => "Nutrition"])]),
            'articlesSante' => $articleRepository->findBy(['user' => $user->getId(), 'articleCategory' => $articleCategoryRepository->findBy(['label' => "Santé"])]),
            'articlesSport' => $articleRepository->findBy(['user' => $user->getId(), 'articleCategory' => $articleCategoryRepository->findBy(['label' => "Sport"])]),
            'workouts' => $workoutProgramRepository->findBy(['user' => $user->getId()], ['publishedAt' => 'ASC']),
        ]);
    }
}
