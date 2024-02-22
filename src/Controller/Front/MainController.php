<?php

namespace App\Controller\Front;

use DateTimeImmutable;
use App\Repository\UserRepository;
use App\Repository\ArticleRepository;
use App\Repository\WorkoutProgramRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class MainController extends AbstractController
{
    /**
     * @Route("/", name="app_home")
     */
    public function home(UserRepository $userRepository, ArticleRepository $articleRepository, WorkoutProgramRepository $workoutProgramRepository): Response
    {
        $today = (new DateTimeImmutable);

        return $this->render('front/main/index.html.twig',[
            'coachs' => $userRepository->search(['roles' => ['role' => 'COACH']], ['firstname' => 'ASC'],4),
            'lastarticle' => $articleRepository->search(['published' => ['only' => true]], ['publishedAt' => 'DESC'],1),
            'articles' => $articleRepository->search(['published' => ['only' => true]], ['publishedAt' => 'DESC'],4,1),
            'programs' => $workoutProgramRepository->search(['published' => ['only' => true]], ['publishedAt' => 'DESC'],6),
        ]);
    }
}
