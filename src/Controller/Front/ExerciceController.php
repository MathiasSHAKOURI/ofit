<?php

namespace App\Controller\Front;

use App\Entity\Exercice;
use App\Repository\ExerciceRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ExerciceController extends AbstractController
{
    /**
     * @Route("/exercices", name="app_exercices")
     */
    public function index(ExerciceRepository $exerciceRepository): Response
    {
        return $this->render('front/exercice/index.html.twig',[
            'musculargroup' => "all"
        ]);
    }

    /**
     * @Route("/exercice/{id}/{slug}", name="app_exercice_show")
     */
    public function show(Exercice $exercice)
    {
        return $this->render('front/exercice/show.html.twig', [
            'exercice' => $exercice,
        ]);
    }

    /**
     * @Route("/exercices/{musculargroup}", name="app_exercice_musculargroup")
     */
    public function muscularGroup($musculargroup, ExerciceRepository $exerciceRepository)
    {
        return $this->render('front/exercice/index.html.twig', [
            'exercices' => $exerciceRepository->search(['muscularGroup' => ['label' => $musculargroup]], ['title' => 'ASC']),
            'musculargroup' => $musculargroup
        ]);
    }
}
