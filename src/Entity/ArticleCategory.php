<?php

namespace App\Entity;

use App\Repository\ArticleCategoryRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * @ORM\Entity(repositoryClass=ArticleCategoryRepository::class)
 */
class ArticleCategory
{
    

    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    const CATEGORIES = ['Santé','Nutrition','Sport'];
    
    /**
     * @ORM\Column(type="string", length=50)
     * @Assert\Unique
     * @Assert\NotBlank
     * @Assert\Length(
     * min = 1,
     * max = 50,
     * minMessage = "Votre titre de catégorie doit comporter au moins {{ limit }} caractères",
     * maxMessage = "Votre titre de catégorie ne peut pas contenir plus de {{ limit }} caractères"
     * )
     * @Assert\Choice(choices=ArticleCategory::CATEGORIES, message="Veuillez choisir une catégorie valide.")
     */
    private $label;

    /**
     * @ORM\OneToMany(targetEntity=Article::class, mappedBy="articleCategory")
     */
    private $articles;

    public function __construct()
    {
        $this->articles = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getLabel(): string
    {
        return $this->label;
    }

    public function setLabel(string $label): self
    {
        $this->label = $label;

        return $this;
    }

    /**
     * @return Collection<int, Article>
     */
    public function getArticles(): Collection
    {
        return $this->articles;
    }

    public function addArticle(Article $article): self
    {
        if (!$this->articles->contains($article)) {
            $this->articles[] = $article;
            $article->setArticleCategory($this);
        }

        return $this;
    }

    public function removeArticle(Article $article): self
    {
        if ($this->articles->removeElement($article)) {
            // set the owning side to null (unless already changed)
            if ($article->getArticleCategory() === $this) {
                $article->setArticleCategory(null);
            }
        }

        return $this;
    }
}
