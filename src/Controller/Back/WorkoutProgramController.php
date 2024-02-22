<?php

namespace App\Controller\Back;

use App\Entity\WorkoutProgram;
use App\Form\WorkoutProgramType;
use App\Repository\WorkoutCategoryRepository;
use App\Repository\WorkoutProgramRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

/**
 * @Route("/admin")
 */
class WorkoutProgramController extends AbstractController
{
    /**
     * @Route("/workout-programs", name="app_back_workoutProgram_index")
     */
    public function workoutProgramsIndex(WorkoutProgramRepository $workoutProgramRepository, WorkoutCategoryRepository $workoutCategoryRepository): Response
    {
        // $all = $workoutProgramRepository->findAll();
        // foreach ($all as $workout) {
        //     $workout->setDuration(1);
        //     $workoutProgramRepository->add($workout, true);
        // };

        return $this->render('back/workoutPrograms/index.html.twig', [
            'workoutPrograms' => $workoutProgramRepository->findBy([], ['publishedAt' => 'DESC']),
            'workoutCategories' => $workoutCategoryRepository->findBy([], ['label' => 'ASC'])
        ]);
    }

    /**
     * @Route("/workout-programs/{category}/all", name="app_back_workoutProgram_index_category")
     */
    public function workoutCategory($category, WorkoutProgramRepository $workoutProgramRepository, WorkoutCategoryRepository $workoutCategoryRepository): Response
    {
        return $this->render('back/workoutPrograms/index.html.twig', [
            'workoutPrograms' => $workoutProgramRepository->search(['category' => ['label' => $category]], ['publishedAt' => 'DESC']),
            'workoutCategories' => $workoutCategoryRepository->findBy([], ['label' => 'ASC'])
        ]);
    }

    /**
     * @Route("/workout-programs/new", name="app_back_workoutProgram_new", methods={"GET", "POST"})
     */
    public function workoutProgramsNew(Request $request, WorkoutProgramRepository $workoutProgramRepository): Response
    {
        $workoutProgram = new WorkoutProgram();
    
        $form = $this->createForm(WorkoutProgramType::class, $workoutProgram);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            if (!$this->isGranted('ROLE_ADMIN')) {
                $workoutProgram->setUser($this->getUser());
            };
            $workoutProgramRepository->add($workoutProgram, true);

            return $this->redirectToRoute('app_back_workoutProgram_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('back/workoutPrograms/new.html.twig', [
            'WorkoutProgram' => $workoutProgram,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/workout-programs/{id}/edit", name="app_back_workoutProgram_edit", methods={"GET", "POST"})
     */
    public function workoutProgramsEdit(Request $request, WorkoutProgram $workoutProgram, WorkoutProgramRepository $workoutProgramRepository): Response
    {
        $originalParameters = new ArrayCollection();
        foreach ($workoutProgram->getWorkoutParameters() as $parameter) {
            $originalParameters->add($parameter);
        };
        $this->denyAccessUnlessGranted("WORKOUT_PROGRAM_EDIT", $workoutProgram);

        $form = $this->createForm(WorkoutProgramType::class, $workoutProgram);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $workoutProgramRepository->add($workoutProgram, true);

            return $this->redirectToRoute('app_back_workoutProgram_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('back/workoutPrograms/edit.html.twig', [
            'workoutProgram' => $workoutProgram,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/workout-programs/{id}", name="app_back_workoutProgram_show")
     */
    public function workoutProgramsShow(WorkoutProgram $workoutProgram): Response
    {
        return $this->render('back/workoutPrograms/show.html.twig', [
            'workoutProgram' => $workoutProgram,
        ]);
    }

    /**
     * @Route("/workout-programs/{id}/delete", name="app_back_workoutProgram_delete", methods={"POST"})
     */
    public function workoutProgramsDelete(Request $request, WorkoutProgram $workoutProgram, WorkoutProgramRepository $workoutProgramRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$workoutProgram->getId(), $request->request->get('_token'))) {
            $workoutProgramRepository->remove($workoutProgram, true);
        }

        return $this->redirectToRoute('app_back_workoutProgram_index', [], Response::HTTP_SEE_OTHER);

    }
}
