<?php

namespace App\Controller\Front;

use App\Entity\User;
use DateTimeImmutable;
use App\Entity\Article;
use App\Repository\UserRepository;
use App\Repository\ArticleRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class ArticleController extends AbstractController
{
    /**
     * @Route("/article-nutrition", name="app_nutrition_article")
     */
    public function indexNutrition(UserRepository $userRepository, ArticleRepository $articleRepository, Request $request): Response
    {
        return $this->render('front/articles/index.html.twig',[
            'coachs' => $userRepository->search(['roles' => ['role' => 'COACH']], ['firstname' => 'ASC']),
            'category' => 'Nutrition',
        ]);
    }

    /**
     * @Route("/article-sport", name="app_sport_article")
     */
    public function indexSport(UserRepository $userRepository, ArticleRepository $articleRepository): Response
    {
        return $this->render('front/articles/index.html.twig',[
            'coachs' => $userRepository->search(['roles' => ['role' => 'COACH']], ['firstname' => 'ASC']),
            'articles' => $articleRepository->search(['categories' => ['category' => 'SPORT'], 'published' => ['only' => true]], ['publishedAt' => 'DESC']),
            'category' => 'Sport'
        ]);
    }

    /**
     * @Route("/article-sante", name="app_santé_article")
     */
    public function indexSante(UserRepository $userRepository, ArticleRepository $articleRepository): Response
    {
        return $this->render('front/articles/index.html.twig',[
            'coachs' => $userRepository->search(['roles' => ['role' => 'COACH']], ['firstname' => 'ASC']),
            'articles' => $articleRepository->search(['categories' => ['category' => 'SANTE'], 'published' => ['only' => true]], ['publishedAt' => 'DESC']),
            'category' => 'Santé'
        ]);
    }

    /**
     * @Route("/article/{id}/{slug}", name="app_article_show")
     */
    public function show(Article $article)
    {
        return $this->render('front/articles/show.html.twig', [
            'article' => $article,
            'category' => $article->getArticleCategory()->getLabel()
        ]);
    }
}
