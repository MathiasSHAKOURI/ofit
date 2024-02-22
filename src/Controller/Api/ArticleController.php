<?php

namespace App\Controller\Api;

use Pagerfanta\Pagerfanta;
use App\Repository\UserRepository;
use Pagerfanta\Adapter\ArrayAdapter;
use App\Repository\ArticleRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;


class ArticleController extends AbstractController
{
    /**
     * @Route("api/article-nutrition", name="app_api_nutrition_article", methods={"GET"})
     */
    public function indexNutrition(Request $request, ArticleRepository $articleRepository, UserRepository $userRepository): JsonResponse
    {
        $currentPage = $request->query->getInt('page', 1);
        $authorId = $request->query->getInt('authorId', 0);
    
        $filters = ['categories' => ['category' => 'NUTRITION'], 'published' => ['only' => true]];

        if ($authorId != 0) {
            $author = $userRepository->find($authorId);
            $filters['author'] = ['authorId' => $authorId];
    
            if (!$author) {
                return $this->json(['message' => 'Auteur non trouvé', 'messageType' => 'danger'], Response::HTTP_NOT_FOUND);
            }
        }

        $results = $articleRepository->search($filters, ['publishedAt' => 'DESC']);
        
        $adapter = new ArrayAdapter($results);
        $pagerfanta = new Pagerfanta($adapter);
        $pagerfanta->setMaxPerPage(6);
        $totalPages = $pagerfanta->getNbPages();
        $totalArticles = $pagerfanta->count();
        
        if ($currentPage > $totalPages ) {
            return $this->json(['message' => 'Cette page n\'existe pas', 'messageType' => 'danger'], Response::HTTP_NOT_FOUND);
        }

        $pagerfanta->setCurrentPage($currentPage);
        $items = $pagerfanta->getCurrentPageResults();
        
        $response = [
            'page' => $currentPage,
            'pages' => $totalPages,
            'total' => $totalArticles,
            'items' => $items, 
        ];

    
        return $this->json($response, Response::HTTP_OK, [], ["groups" => "articleIndex"]);
    }

    /**
     * @Route("api/article-sport", name="app_api_sport_article", methods={"GET"})
     */
    public function indexSport(Request $request, UserRepository $userRepository, ArticleRepository $articleRepository): JsonResponse
    {
        $currentPage = $request->query->getInt('page', 1);
        $authorId = $request->query->getInt('authorId', 0);

        if ($authorId !== 0) {
            $author = $userRepository->find($authorId);
    
            if (!$author) {
                return $this->json(['message' => 'Auteur non trouvé', 'messageType' => 'danger'], Response::HTTP_NOT_FOUND);
            }
        }

        $filters = ['categories' => ['category' => 'SPORT'], 'published' => ['only' => true]];
        if ($authorId != 0) {
            $filters['author'] = ['authorId' => $authorId];
        }
        $results = $articleRepository->search($filters, ['publishedAt' => 'DESC']);
        
        $adapter = new ArrayAdapter($results);
        $pagerfanta = new Pagerfanta($adapter);
        $pagerfanta->setMaxPerPage(6);
        $totalPages = $pagerfanta->getNbPages();
        $totalArticles = $pagerfanta->count();
        
        if ($currentPage > $totalPages ) {
            return $this->json(['message' => 'Cette page n\'existe pas', 'messageType' => 'danger'], Response::HTTP_NOT_FOUND);
        }

        $pagerfanta->setCurrentPage($currentPage);
        $items = $pagerfanta->getCurrentPageResults();

        $response = [
            'page' => $currentPage,
            'pages' => $totalPages,
            'total' => $totalArticles,
            'items' => $items, 
        ];
    
        return $this->json($response, Response::HTTP_OK, [], ["groups" => "articleIndex"]);
    }

    /**
     * @Route("api/article-santé", name="app_api_sport_sante", methods={"GET"})
     */
    public function indexSante(Request $request, UserRepository $userRepository, ArticleRepository $articleRepository): JsonResponse
    {
        $currentPage = $request->query->getInt('page', 1);
        $authorId = $request->query->getInt('authorId', 0);

        if ($authorId !== 0) {
            $author = $userRepository->find($authorId);
    
            if (!$author) {
                return $this->json(['message' => 'Auteur non trouvé', 'messageType' => 'danger'], Response::HTTP_NOT_FOUND);
            }
        }

        $filters = ['categories' => ['category' => 'SANTE'], 'published' => ['only' => true]];
        if ($authorId != 0) {
            $filters['author'] = ['authorId' => $authorId];
        }
        $results = $articleRepository->search($filters, ['publishedAt' => 'DESC']);
        
        $adapter = new ArrayAdapter($results);
        $pagerfanta = new Pagerfanta($adapter);
        $pagerfanta->setMaxPerPage(6);
        $totalPages = $pagerfanta->getNbPages();
        $totalArticles = $pagerfanta->count();
        
        if ($currentPage > $totalPages ) {
            return $this->json(['message' => 'Cette page n\'existe pas', 'messageType' => 'danger'], Response::HTTP_NOT_FOUND);
        }

        $pagerfanta->setCurrentPage($currentPage);
        $items = $pagerfanta->getCurrentPageResults();
    
        $response = [
            'page' => $currentPage,
            'pages' => $totalPages,
            'total' => $totalArticles,
            'items' => $items, 
        ];
    
        return $this->json($response, Response::HTTP_OK, [], ["groups" => "articleIndex"]);
    } 
}
