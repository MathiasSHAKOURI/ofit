<?php
namespace App\EventListener;

use App\Entity\Article;
use Symfony\Component\String\Slugger\SluggerInterface;

class ArticleListener{

    private $slugger;

    public function __construct(SluggerInterface $slugger)
    {
        $this->slugger = $slugger;
    }

    public function slugifyTitle(Article $article)
    {
        $article->setSlug(strtolower($this->slugger->slug($article->getTitle())));
    }

    public function setCreatedAt(Article $article)
    {
        $article->setCreatedAt(new \DateTimeImmutable("now"));
    }

    public function setUpdatedAt(Article $article)
    {
        $article->setUpdatedAt(new \DateTimeImmutable("now"));
    }

    public function setPicture(Article $article)
    {
        if (!$article->getPicture() && $article->getArticleCategory()->getLabel() === "Nutrition")
        {
            $article->setPicture('https://images.pexels.com/photos/1640777/pexels-photo-1640777.jpeg?auto=compress&cs=tinysrgb&w=600');
        }
        else if (!$article->getPicture() && $article->getArticleCategory()->getLabel() === "Santé")
        {
            $article->setPicture('https://images.pexels.com/photos/7203694/pexels-photo-7203694.jpeg?auto=compress&cs=tinysrgb&w=600');

        }
        else if (!$article->getPicture() && $article->getArticleCategory()->getLabel() === "Sport")
        {
            $article->setPicture('https://www.pexels.com/fr-fr/photo/homme-portant-un-debardeur-noir-et-en-cours-d-execution-sur-le-bord-de-mer-1390403/');

        };
    }
}