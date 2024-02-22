<?php

namespace App\Entity;

use App\Repository\ArticleRepository;
use DateTimeImmutable;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\String\Slugger\SluggerInterface;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * @ORM\Entity(repositoryClass=ArticleRepository::class)
 * @UniqueEntity(
 *  "title",
 *  message = "Le titre doit être unique."
 * )
 * @UniqueEntity(
 *  "picture",
 *  message = "L'url doit être unique."
 * )
 */
class Article
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     * @Groups({"articleIndex"})
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=100, unique=true)
     * @Assert\NotBlank
     * @Assert\Length(
     * min = 1,
     * max = 100,
     * minMessage = "Votre titre doit comporter au moins {{ limit }} caractères",
     * maxMessage = "Votre titre ne peut pas contenir plus de {{ limit }} caractères"
     * )
     * @Groups({"articleIndex"})
     */
    private $title;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     * @Assert\Url
     * @Assert\Length(
     * min = 1,
     * max = 255,
     * minMessage = "Votre url doit comporter au moins {{ limit }} caractères",
     * maxMessage = "Votre url ne peut pas contenir plus de {{ limit }} caractères"
     * )
     * @Groups({"articleIndex"})
     */
    private $picture;

    /**
     * @ORM\Column(type="text")
     * @Assert\NotBlank
     * @Assert\Length(
     * min = 1000,
     * max = 65535,
     * minMessage = "Votre article doit comporter au moins {{ limit }} caractères",
     * maxMessage = "Votre article ne peut pas contenir plus de {{ limit }} caractères"
     * )
     * @Groups({"articleIndex"})
     */
    private $content;

    /**
     * @ORM\Column(type="string", length=100)
     * @Assert\Length(
     * min = 1,
     * max = 100
     * )
     * @Groups({"articleIndex"})
     */
    private $slug;

    /**
     * @ORM\Column(type="datetime_immutable")
     */
    private $createdAt;

    /**
     * @ORM\Column(type="datetime_immutable", nullable=true)
     */
    private $updatedAt;

    /**
     * @ORM\Column(type="datetime_immutable")
     * @Assert\NotBlank
     * @Groups({"articleIndex"})
     */
    private $publishedAt;

    /**
     * @ORM\ManyToOne(targetEntity=ArticleCategory::class, inversedBy="articles")
     * @ORM\JoinColumn(nullable=false)
     */
    private $articleCategory;

    /**
     * @ORM\ManyToOne(targetEntity=User::class, inversedBy="articles")
     * @Groups({"articleIndex"})
     */
    private $user;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitle(): string
    {
        return $this->title;
    }

    public function setTitle(string $title): self
    {
        $this->title = $title;

        return $this;
    }

    public function getPicture(): ?string
    {
        return $this->picture;
    }

    public function setPicture(?string $picture): self
    {
        $this->picture = $picture;

        return $this;
    }

    public function getContent(): string
    {
        return $this->content;
    }

    public function setContent(string $content): self
    {
        $this->content = $content;

        return $this;
    }

    public function getSlug(): string
    {
        return $this->slug;
    }

    public function setSlug(string $slug): self
    {
        $this->slug = $slug;

        return $this;
    }

    public function getCreatedAt(): \DateTimeImmutable
    {
        return $this->createdAt;
    }
    
    public function setCreatedAt(\DateTimeImmutable $createdAt): self
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    public function getUpdatedAt(): ?\DateTimeImmutable
    {
        return $this->updatedAt;
    }

    public function setUpdatedAt(?\DateTimeImmutable $updatedAt): self
    {
        $this->updatedAt = $updatedAt;

        return $this;
    }

    public function getPublishedAt(): ?\DateTimeImmutable
    {
        return $this->publishedAt;
    }

    public function setPublishedAt(?\DateTimeImmutable $publishedAt): self
    {
        $this->publishedAt = $publishedAt;

        return $this;
    }

    public function getArticleCategory(): ?ArticleCategory
    {
        return $this->articleCategory;
    }

    public function setArticleCategory(?ArticleCategory $articleCategory): self
    {
        $this->articleCategory = $articleCategory;

        return $this;
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): self
    {
        $this->user = $user;

        return $this;
    }
}
