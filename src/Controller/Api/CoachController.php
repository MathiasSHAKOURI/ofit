<?php

namespace App\Controller\Api;

use App\Repository\UserRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Pagerfanta\Adapter\ArrayAdapter;
use Pagerfanta\Pagerfanta;

class CoachController extends AbstractController
{
    /**
     * @Route("/api/coachs", name="app_api_coach", methods={"GET"})
     */
    public function index(Request $request, UserRepository $userRepository): JsonResponse
    {
        $currentPage = $request->query->getInt('page', 1);
        $results = $userRepository->search(['roles' => ['role' => 'COACH']], ['firstname' => 'ASC']);
        
        $adapter = new ArrayAdapter($results);
        $pagerfanta = new Pagerfanta($adapter);
        $pagerfanta->setMaxPerPage(8);
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
    
        return $this->json($response, Response::HTTP_OK, [], ["groups" => "coachIndex"]);
    }
}