<?php

namespace App\Entity;

use DateTimeImmutable;
use App\Entity\WorkoutCategory;
use App\Entity\WorkoutParameter;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\Collection;
use App\Repository\WorkoutProgramRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Serializer\Annotation\Groups;


/**
 * @ORM\Entity(repositoryClass=WorkoutProgramRepository::class)
 */
class WorkoutProgram
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     * @Groups({"workoutIndex"})
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=100)
     * @Assert\NotBlank
     * @Assert\Length(
     * min = 1,
     * max = 100,
     * minMessage = "Votre titre doit comporter au moins {{ limit }} caractères",
     * maxMessage = "Votre titre ne peut pas contenir plus de {{ limit }} caractères"
     * )
     * @Groups({"workoutIndex"})
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
     * @Groups({"workoutIndex"})
     */
    private $picture;

    /**
     * @ORM\Column(type="text")
     * @Assert\NotBlank
     * @Assert\Length(
     * min = 100,
     * max = 65535,
     * minMessage = "Votre article doit comporter au moins {{ limit }} caractères",
     * maxMessage = "Votre article ne peut pas contenir plus de {{ limit }} caractères"
     * )
     */
    private $description;

    /**
     * @ORM\Column(type="integer", nullable=true)
     * @Assert\Positive
     * @Assert\Type(
     *     type="integer",
     *     message="La {{ value }} n'est pas un entier."
     * )
     * @Groups({"workoutIndex"})
     */
    private $duration;

    /**
     * @ORM\ManyToOne(targetEntity=WorkoutCategory::class, inversedBy="workoutPrograms")
     * @ORM\JoinColumn(nullable=false)
     * @Assert\NotBlank
     * @Groups({"workoutIndex"})
     */
    private $workoutCategory;

    /**
     * @ORM\OneToMany(targetEntity=WorkoutParameter::class, mappedBy="workoutProgram", orphanRemoval=true, cascade={"persist"})
     * @Assert\Valid
     * @Groups({"workoutIndex"})
     */
    private $workoutParameters;

    /**
     * @ORM\ManyToOne(targetEntity=User::class, inversedBy="workoutPrograms")
     * @ORM\JoinColumn(nullable=true)
     * @Groups({"workoutIndex"})
     */
    private $user;

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
     */
    private $publishedAt;

    /**
     * @ORM\Column(type="string", length=100)
     * @Assert\Length(
     * min = 1,
     * max = 100
     * )
     * @Groups({"workoutIndex"})
     */
    private $slug;

    const RESTBETWEEN = [60,90,120,150,180,210,240,270,300];

    /**
     * @ORM\Column(type="integer")
     * @Assert\NotBlank
     * @Assert\Positive
     * @Assert\Type(
     *     type="integer",
     *     message="La {{ value }} n'est pas un entier."
     * )
     * @Assert\Choice(choices=WorkoutProgram::RESTBETWEEN, message="Veuillez choisir un temps de repos valide.")
     */
    private $restBetween;

    public function __construct()
    {
        $this->workoutParameters = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitle(): ?string
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

    public function getDescription(): string
    {
        return $this->description;
    }

    public function setDescription(string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getDuration()
    {
        return $this->duration;
    }

    public function setDuration(int $duration): self
    {
        $this->duration = $duration;

        return $this;
    }

    public function getWorkoutCategory(): ?WorkoutCategory
    {
        return $this->workoutCategory;
    }

    public function setWorkoutCategory(?WorkoutCategory $workoutCategory): self
    {
        $this->workoutCategory = $workoutCategory;

        return $this;
    }

    /**
     * @return Collection<int, WorkoutParameter>
     */
    public function getWorkoutParameters(): Collection
    {
        return $this->workoutParameters;
    }

    public function addWorkoutParameter(WorkoutParameter $workoutParameter): self
    {
        if (!$this->workoutParameters->contains($workoutParameter)) {
            $this->workoutParameters[] = $workoutParameter;
            $workoutParameter->setWorkoutProgram($this);
        }

        return $this;
    }

    public function removeWorkoutParameter(WorkoutParameter $workoutParameter): self
    {
        if ($this->workoutParameters->removeElement($workoutParameter)) {
            // set the owning side to null (unless already changed)
            if ($workoutParameter->getWorkoutProgram() === $this) {
                $workoutParameter->setWorkoutProgram(null);
            }
        }

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

    public function getCreatedAt(): \DateTimeImmutable
    {
        return $this->createdAt;
    }

    public function setCreatedAt(\DateTimeImmutable $createdAt): self
    {
        $this->createdAt = $createdAt;
        // $this->createdAt = new DateTimeImmutable("now");

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

    public function getSlug(): ?string
    {
        return $this->slug;
    }

    public function setSlug(string $slug): self
    {
        $this->slug = $slug;

        return $this;
    }

    public function getRestBetween(): ?int
    {
        return $this->restBetween;
    }

    public function setRestBetween(int $restBetween): self
    {
        $this->restBetween = $restBetween;

        return $this;
    }
}
