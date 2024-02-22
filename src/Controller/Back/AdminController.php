<?php

namespace App\Controller\Back;

use App\Repository\UserRepository;
use App\Repository\ArticleRepository;
use App\Repository\ExerciceRepository;
use App\Repository\WorkoutProgramRepository;
use App\Repository\ArticleCategoryRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

/**
 * @Route("/admin")
 */
class AdminController extends AbstractController
{
    /**
     * @Route("/login", name="app_back_login")
     */
    public function login(AuthenticationUtils $authenticationUtils): Response
    {
        if ($this->getUser()) {
            return $this->redirectToRoute('app_back_dashboard');
        };
        
        $error = $authenticationUtils->getLastAuthenticationError();
        $lastUsername = $authenticationUtils->getLastUsername();

        return $this->render('back/security/index.html.twig', [
            'last_username' => $lastUsername,
            'error'         => $error,
        ]);
    }

    /**
    * @Route("/logout", name="app_back_logout")
    */
    public function logout(): void
    {
    }

    /**
     * @Route("/", name="app_back_dashboard")
     */
    public function index(ArticleRepository $articleRepository, ExerciceRepository $exerciceRepository, WorkoutProgramRepository $workoutProgramRepository, ArticleCategoryRepository $articleCategoryRepository): Response
    {
        $articlesCountPublished = $articleRepository->countArticlesByCategory('<=');
        foreach ($articlesCountPublished as $arrayNumber => $value)
        {
            $articlesCountPublished[$value["label"]] = $value["count"];
            unset($articlesCountPublished[$arrayNumber]);
        };
        
        $articlesCountToPublish = $articleRepository->countArticlesByCategory('>');
        foreach ($articlesCountToPublish as $arrayNumber => $value)
        {
            $articlesCountToPublish[$value["label"]] = $value["count"];
            unset($articlesCountToPublish[$arrayNumber]);
        };
        
        return $this->render('back/dashboard/index.html.twig', [
            'exercicesCount' => $exerciceRepository->countExercices(),
            'workoutProgramsCountPublished' => $workoutProgramRepository->countWorkoutProgram('<='),
            'workoutProgramsCountToPublish' => $workoutProgramRepository->countWorkoutProgram('>'),
            'articlesCountPublished' => $articlesCountPublished,
            'articlesCountToPublish' => $articlesCountToPublish,
            'articlesCategories' => $articleCategoryRepository->findAll(),
        ]);
    }

    /**
     * @Route("/search/global-results", name="app_search_results_global_back")
     */
    public function searchGlobalResults(Request $request, UserRepository $userRepository, ArticleRepository $articleRepository, ExerciceRepository $exerciceRepository, WorkoutProgramRepository $workoutCategoryRepository): Response
    {
        $globalSearch = $request->query->get('globalSearch');
        return $this->render('back/search/globalResults.html.twig', [
            'userInput' => $globalSearch,
            'articles' => $articleRepository->search(['userInputs' => ['userInput' => $globalSearch]], ['publishedAt' => 'DESC']),
            'coachs' => $userRepository->search(['roles' => ['role' => 'COACH'], 'userInputs' => ['userInput' => $globalSearch]], ['firstname' => 'ASC']),
            'exercices' => $exerciceRepository->search(['userInputs' => ['userInput' => $globalSearch]], ['title' => 'ASC']),
            'workouts' => $workoutCategoryRepository->search(['published' => ['only' => true], 'userInputs' => ['userInput' => $globalSearch]], ['publishedAt' => 'DESC']),
        ]);
    }
}
