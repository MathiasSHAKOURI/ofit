<?php

namespace App\Controller\Back;

use App\Entity\Article;
use App\Entity\ArticleCategory;
use App\Form\ArticleType;
use App\Repository\ArticleCategoryRepository;
use App\Repository\ArticleRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

/**
 * @Route("/admin")
 */
class ArticleController extends AbstractController
{
    /**
     * @Route("/articles", name="app_back_article_index")
     */
    public function articlesIndex(ArticleRepository $articleRepository, ArticleCategoryRepository $articleCategoryRepository): Response
    {
        return $this->render('back/articles/index.html.twig', [
            'articles' => $articleRepository->findBy([], ['publishedAt' => 'DESC']),
            'articleCategories' => $articleCategoryRepository->findBy([],['label' => 'ASC']),
        ]);
    }

    /**
     * @Route("/articles/{category}/all", name="app_back_article_index_category")
     */
    public function articlesCategory($category, ArticleRepository $articleRepository, ArticleCategoryRepository $articleCategoryRepository): Response
    {
        return $this->render('back/articles/index.html.twig', [
            'articles' => $articleRepository->search(['categories' => ['category' => $category]], ['publishedAt' => 'DESC']),
            'articleCategories' => $articleCategoryRepository->findBy([],['label' => 'ASC']),
        ]);
    }

    /**
     * @Route("/articles/new", name="app_back_article_new", methods={"GET", "POST"})
     */
    public function articlesNew(Request $request, ArticleRepository $articleRepository): Response
    {
        $article = new Article();
        $form = $this->createForm(ArticleType::class, $article);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            if (!$this->isGranted('ROLE_ADMIN')) {
                $article->setUser($this->getUser());
            };
            $articleRepository->add($article, true);
            return $this->redirectToRoute('app_back_article_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('back/articles/new.html.twig', [
            'article' => $article,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/articles/{id}/edit", name="app_back_article_edit", methods={"GET", "POST"})
     */
    public function articlesEdit(Request $request, Article $article, ArticleRepository $articleRepository): Response
    {
        $this->denyAccessUnlessGranted("ARTICLE_EDIT", $article);

        $form = $this->createForm(ArticleType::class, $article);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $articleRepository->add($article, true);

            return $this->redirectToRoute('app_back_article_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('back/articles/edit.html.twig', [
            'article' => $article,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/articles/{id}", name="app_back_article_show", methods={"GET"})
     */
    public function articlesShow(Article $article): Response
    {
        return $this->render('back/articles/show.html.twig', [
            'article' => $article,
        ]);
    }

    /**
     * @Route("/articles/{id}/delete", name="app_back_article_delete", methods={"POST"})
     */
    public function articlesDelete(Request $request, Article $article, ArticleRepository $articleRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$article->getId(), $request->request->get('_token'))) {
            $articleRepository->remove($article, true);
        }

        return $this->redirectToRoute('app_back_article_index', [], Response::HTTP_SEE_OTHER);
    }
}