<?php

namespace App\Controller\Front;

use App\Entity\WorkoutProgram;
use App\Repository\UserRepository;
use App\Repository\WorkoutCategoryRepository;
use App\Repository\WorkoutProgramRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class WorkoutController extends AbstractController
{
    /**
     * @Route("/programmes", name="app_workout")
     */
    public function index(WorkoutProgramRepository $workoutProgramRepository, UserRepository $userRepository, WorkoutCategoryRepository $workoutCategoryRepository): Response
    {
        return $this->render('front/workout/index.html.twig', [
            'workouts' => $workoutProgramRepository->findBy([], ['publishedAt' => 'ASC']),
            'coachs' => $userRepository->search(['roles' => ['role' => 'COACH']], ['pseudo' => 'ASC']),
            'categories' => $workoutCategoryRepository->findBy([], ['label' => 'ASC']),
        ]);
    }
    
    /**
     * @Route("/programme/{id}/{slug}", name="app_workout_show")
     */
    public function show(WorkoutProgram $workoutProgram)
    {
        return $this->render('front/workout/show.html.twig', [
            'workout' => $workoutProgram,
        ]);
    }
}
