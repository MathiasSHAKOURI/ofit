<?php

namespace App\Controller\Api;

use App\Repository\ExerciceRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Pagerfanta\Adapter\ArrayAdapter;
use Pagerfanta\Pagerfanta;

class ExerciceController extends AbstractController
{
    /**
     * @Route("/api/exercices", name="app_api_exercices", methods={"GET"})
     */
    public function index(Request $request, ExerciceRepository $exerciceRepository): JsonResponse
    {
        $currentPage = $request->query->getInt('page', 1);
        $muscularGroup = $request->query->get('muscularGroup', "all");
        $filters =[];
        if ($muscularGroup != "all") {
            $mg = $exerciceRepository->find($muscularGroup);
            $filters['muscularGroup'] = ['label' => $muscularGroup];
        }

        $results = $exerciceRepository->search($filters, ['title' => 'ASC']);
        
        $adapter = new ArrayAdapter($results);
        $pagerfanta = new Pagerfanta($adapter);
        $pagerfanta->setMaxPerPage(6);
        $totalPages = $pagerfanta->getNbPages();
        $totalCoaches = $pagerfanta->count();
        
        if ($currentPage > $totalPages ) {
            return $this->json(['message' => 'Cette page n\'existe pas', 'messageType' => 'danger'], Response::HTTP_NOT_FOUND);
        }
        
        $pagerfanta->setCurrentPage($currentPage);
        $items = $pagerfanta->getCurrentPageResults();

        $response = [
            'page' => $currentPage,
            'pages' => $totalPages,
            'total' => $totalCoaches,
            'items' => $items, 
        ];
    
        return $this->json($response, Response::HTTP_OK, [], ["groups" => "exerciceIndex"]);
    }
}