<?php

namespace App\Controller\Front;

use App\Entity\WorkoutProgram;
use App\Repository\UserRepository;
use App\Repository\ArticleRepository;
use App\Repository\ExerciceRepository;
use App\Repository\WorkoutCategoryRepository;
use App\Repository\WorkoutProgramRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class SearchController extends AbstractController
{
    /**
     * @Route("/search/article-results", name="app_search_results_article")
     */
    public function searchArticleResults(Request $request, UserRepository $userRepository, ArticleRepository $articleRepository): Response
    {
        $id = $request->query->get('id');
        $category = $request->query->get('category');
        return $this->render('front/search/results.html.twig', [
            'coach' => $userRepository->find($id),
            'articles' => $articleRepository->search(['categories' => ['category' => $category], 'author' => ['authorId' => $id], 'published' => ['only' => true]], ['publishedAt' => 'DESC']),

            'category' => $category
        ]);
    }

    /**
     * @Route("/search/workout-results", name="app_search_results_workout")
     */
    public function searchWorkoutResults(Request $request, WorkoutProgramRepository $workoutProgramRepository, UserRepository $userRepository, WorkoutCategoryRepository $workoutCategoryRepository): Response
    {
        $id = $request->query->get('coachId');
        $category = $request->query->get('category');
        $min = $request->query->get('min');
        $max = $request->query->get('max');
        $workouts = $workoutProgramRepository->search(
            [
                'published' => ['only' => true],
                'userInputs' => [
                    'id' => $id,
                    'category' => $category,
                    'min' => $min,
                    'max' => $max
                ]
            ],
            ['publishedAt' => 'DESC']
        );

        return $this->render('front/search/workoutResults.html.twig', [
            'workouts' => $workouts,
            'coachs' => $userRepository->search(['roles' => ['role' => 'COACH']]),
            'categories' => $workoutCategoryRepository->findBy([], ['label' => 'ASC']),
            'min' => $min,
            'max' => $max,
            'selectedCategory' => $category,
            'selectedCoach' => $id,
        ]);
    }

    /**
     * @Route("/search/global-results", name="app_search_results_global")
     */
    public function searchGlobalResults(Request $request, UserRepository $userRepository, ArticleRepository $articleRepository, ExerciceRepository $exerciceRepository, WorkoutProgramRepository $workoutCategoryRepository): Response
    {
        $globalSearch = $request->query->get('globalSearch');
        return $this->render('front/search/globalResults.html.twig', [
            'userInput' => $globalSearch,
            'articles' => $articleRepository->search(['published' => ['only' => true], 'userInputs' => ['userInput' => $globalSearch]], ['publishedAt' => 'DESC']),
            'coachs' => $userRepository->search(['roles' => ['role' => 'COACH'], 'userInputs' => ['userInput' => $globalSearch]], ['firstname' => 'ASC']),
            'exercices' => $exerciceRepository->search(['userInputs' => ['userInput' => $globalSearch]], ['title' => 'ASC']),
            'workouts' => $workoutCategoryRepository->search(['published' => ['only' => true], 'userInputs' => ['userInput' => $globalSearch]], ['publishedAt' => 'DESC']),
        ]);
    }
}

