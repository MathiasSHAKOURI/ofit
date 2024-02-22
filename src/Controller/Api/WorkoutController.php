<?php

namespace App\Controller\Api;

use App\Entity\WorkoutCategory;
use App\Entity\WorkoutProgram;
use App\Repository\UserRepository;
use App\Repository\WorkoutCategoryRepository;
use App\Repository\WorkoutProgramRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Pagerfanta\Adapter\ArrayAdapter;
use Pagerfanta\Pagerfanta;

class WorkoutController extends AbstractController
{
    /**
     * @Route("/api/programmes", name="app_api_workout", methods={"GET"})
     */
    public function index(Request $request,WorkoutProgramRepository $workoutProgramRepository, WorkoutCategoryRepository $workoutCategoryRepository, UserRepository $userRepository): JsonResponse
    {
        $currentPage = $request->query->getInt('page', 1);
        $categoryId = $request->query->getInt('categoryId', 0);
        $authorId = $request->query->getInt('authorId', 0);
        $min = $request->query->getInt('min', 0);
        $max = $request->query->getInt('max', 0);
        
        $filters = ['published' => ['only' => true]];
        
        if ($categoryId !== 0) {
            $category = $workoutCategoryRepository->find($categoryId);
            $filters['category'] = ['categoryId' => $categoryId];
            
            if (!$category) {
                return $this->json(['message' => 'Cette catégorie n\'existe pas', 'messageType' => 'danger'], Response::HTTP_NOT_FOUND);
            }
        }
        
        if ($authorId !== 0) {
            $author = $userRepository->find($authorId);
            $filters['author'] = ['authorId' => $authorId];
            
            if (!$author) {
                return $this->json(['message' => 'Auteur non trouvé', 'messageType' => 'danger'], Response::HTTP_NOT_FOUND);
            }
        }

        if ($min !== 0) {
            $filters['min'] = ['min' => $min];
        }

        if ($max !== 0) {
            $filters['max'] = ['max' => $max];
        }

        if ($min > $max && $max !== 0) {
            return $this->json(['message' => 'La durée minimum ne doit pas être supérieure à la durée maximum', 'messageType' => 'danger'], Response::HTTP_BAD_REQUEST);
        }

        $results = $workoutProgramRepository->search($filters, ['publishedAt' => 'DESC']);
        
        $adapter = new ArrayAdapter($results);
        $pagerfanta = new Pagerfanta($adapter);
        $pagerfanta->setMaxPerPage(4);
        $pagerfanta->setCurrentPage($currentPage);
        $items = $pagerfanta->getCurrentPageResults();
        $totalPages = $pagerfanta->getNbPages();
        $totalCoaches = $pagerfanta->count();
    
        $response = [
            'page' => $currentPage,
            'pages' => $totalPages,
            'total' => $totalCoaches,
            'items' => $items, 
        ];
    
        return $this->json($response, Response::HTTP_OK, [], ["groups" => "workoutIndex"]);
    }
}