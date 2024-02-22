<?php

namespace App\Controller\Back;

use App\Entity\User;
use App\Form\UserType;
use App\Repository\UserRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

/**
 * @Route("/admin")
 */
class UserController extends AbstractController
{
    /**
     * @Route("/coachs", name="app_back_coach_index")
     */
    public function usersIndex(UserRepository $userRepository): Response
    {
        return $this->render('back/coachs/index.html.twig', [
            'users' => $userRepository->search(['roles' => ['role' => 'COACH']], ['firstname' => 'ASC']),
        ]);
    }

    /**
     * @Route("/coachs/new", name="app_back_coach_new", methods={"GET", "POST"})
     */
    public function usersNew(Request $request, UserRepository $userRepository, UserPasswordHasherInterface $passwordHasher): Response
    {
        $user = new User();
        $form = $this->createForm(UserType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $plaintextPassword = $user->getPassword();
            $hashedPassword = $passwordHasher->hashPassword($user,$plaintextPassword);
            $user->setPassword($hashedPassword);
            $user->setRoles(["ROLE_COACH"]);

            $userRepository->add($user, true);

            return $this->redirectToRoute('app_back_coach_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('back/coachs/new.html.twig', [
            'user' => $user,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/coachs/{id}/edit", name="app_back_coach_edit", methods={"GET", "POST"})
     */
    public function usersEdit(Request $request, User $user, UserRepository $userRepository, UserPasswordHasherInterface $passwordHasher): Response
    {
        $form = $this->createForm(UserType::class, $user, ['custom_option' => 'edit']);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $plaintextPassword = $user->getPassword();
            $hashedPassword = $passwordHasher->hashPassword($user,$plaintextPassword);
            $user->setPassword($hashedPassword);
            $userRepository->add($user, true);

            return $this->redirectToRoute('app_back_coach_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('back/coachs/edit.html.twig', [
            'user' => $user,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/coachs/{id}", name="app_back_coach_show")
     */
    public function usersShow(User $user): Response
    {
        return $this->render('back/coachs/show.html.twig', [
            'user' => $user,
        ]);
    }

    /**
     * @Route("/coachs/{id}/delete", name="app_back_coach_delete", methods={"POST"})
     */
    public function usersDelete(Request $request, User $user, UserRepository $userRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$user->getId(), $request->request->get('_token'))) {
            $userRepository->remove($user, true);
        }

        return $this->redirectToRoute('app_back_coach_index', [], Response::HTTP_SEE_OTHER);
    }

    /**
     * @Route("/mon-profil", name="app_back_my_profile")
     */
    public function coachProfileShow(): Response
    {
        return $this->render('back/coachs/show.html.twig', [
            'user' => $this->getUser(),
        ]);
    }

    /**
     * @Route("/mon-profil/edit", name="app_back_my_profile_edit", methods={"GET", "POST"})
     */
    public function coachProfileEdit(Request $request, UserRepository $userRepository): Response
    {
        $currentUser = $this->getUser();

        $form = $this->createForm(UserType::class, $currentUser, ['custom_option' => 'edit']);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $userRepository->add($currentUser, true);

            return $this->redirectToRoute('app_back_my_profile', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('back/coachs/edit.html.twig', [
            'user' => $currentUser,
            'form' => $form,
        ]);
    }
}
