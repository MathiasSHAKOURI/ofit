<?php

namespace App\Controller\Back;

use App\Entity\Exercice;
use App\Form\ExerciceType;
use App\Repository\ExerciceRepository;
use App\Repository\MuscularGroupRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

/**
 * @Route("/admin")
 */
class ExerciceController extends AbstractController
{
    /**
     * @Route("/exercices", name="app_back_exercice_index")
     */
    public function exercicesIndex(ExerciceRepository $exerciceRepository, MuscularGroupRepository $muscularGroupRepository): Response
    {
        return $this->render('back/exercices/index.html.twig', [
            'exercices' => $exerciceRepository->findBy([], ['title' => 'ASC']),
            'muscularGroups' => $muscularGroupRepository->findBy([], ['label' => 'ASC'])   
        ]);
    }
    /**
     * @Route("/exercices/{muscularGroup}/all", name="app_back_exercice_index_muscularGroup")
     */
    public function exercicesMuscularGroup($muscularGroup, ExerciceRepository $exerciceRepository, MuscularGroupRepository $muscularGroupRepository): Response
    {
        return $this->render('back/exercices/index.html.twig', [
            'exercices' => $exerciceRepository->search(['muscularGroup' => ['label' => $muscularGroup]], ['title' => 'ASC']),
            'muscularGroups' => $muscularGroupRepository->findBy([], ['label' => 'ASC'])
        ]);
    }

    /**
     * @Route("/exercices/new", name="app_back_exercice_new", methods={"GET", "POST"})
     */
    public function exercicesNew(Request $request, ExerciceRepository $exerciceRepository): Response
    {
        $exercice = new Exercice();
        $form = $this->createForm(ExerciceType::class, $exercice);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $exerciceRepository->add($exercice, true);

            return $this->redirectToRoute('app_back_exercice_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('back/exercices/new.html.twig', [
            'exercice' => $exercice,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/exercices/{id}/edit", name="app_back_exercice_edit", methods={"GET", "POST"})
     */
    public function exercicesEdit(Request $request, Exercice $exercice, ExerciceRepository $exerciceRepository): Response
    {
        $form = $this->createForm(ExerciceType::class, $exercice);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $exerciceRepository->add($exercice, true);

            return $this->redirectToRoute('app_back_exercice_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('back/exercices/edit.html.twig', [
            'exercice' => $exercice,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/exercices/{id}", name="app_back_exercice_show")
     */
    public function exercicesShow(Exercice $exercice): Response
    {
        return $this->render('back/exercices/show.html.twig', [
            'exercice' => $exercice,
        ]);
    }

    /**
     * @Route("/exercices/{id}/delete", name="app_back_exercice_delete", methods={"POST"})
     */
    public function exercicesDelete(Request $request, Exercice $exercice, ExerciceRepository $exerciceRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$exercice->getId(), $request->request->get('_token'))) {
            $exerciceRepository->remove($exercice, true);
        }

        return $this->redirectToRoute('app_back_exercice_index', [], Response::HTTP_SEE_OTHER);
    }
}