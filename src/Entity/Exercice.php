<?php

namespace App\Entity;

use App\Entity\MuscularGroup;
use Doctrine\ORM\Mapping as ORM;
use App\Repository\ExerciceRepository;
use Doctrine\Common\Collections\Collection;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * @ORM\Entity(repositoryClass=ExerciceRepository::class)
 */
class Exercice
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     * @Groups({"exerciceIndex", "workoutIndex"})
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
     * @Groups({"exerciceIndex", "workoutIndex"})
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
     * @Groups({"exerciceIndex", "workoutIndex"})
     */
    private $picture;

    /**
     * @ORM\Column(type="string", length=100)
     * @Assert\Length(
     * min = 1,
     * max = 100
     * )
     * @Groups({"exerciceIndex", "workoutIndex"})
     */
    private $slug;

    /**
     * @ORM\ManyToOne(targetEntity=MuscularGroup::class, inversedBy="exercices")
     * @ORM\JoinColumn(nullable=false)
     * @Assert\NotBlank
     * @Groups({"exerciceIndex"})
     */
    private $muscularGroup;

    /**
     * @ORM\OneToMany(targetEntity=WorkoutParameter::class, mappedBy="exercice", orphanRemoval=true)
     */
    private $workoutParameters;

    /**
     * @ORM\Column(type="text")
     * @Assert\NotBlank
     * @Assert\Length(
     * min = 100,
     * max = 65535,
     * minMessage = "Votre exercice doit comporter au moins {{ limit }} caractères",
     * maxMessage = "Votre exercice ne peut pas contenir plus de {{ limit }} caractères"
     * )
     * @Groups({"exerciceIndex"})
     */
    private $description;

    public function __construct()
    {
        $this->workoutParameters = new ArrayCollection();
    }

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

    public function getSlug(): string
    {
        return $this->slug;
    }

    public function setSlug(string $slug): self
    {
        $this->slug = $slug;

        return $this;
    }

    public function getMuscularGroup(): ?MuscularGroup
    {
        return $this->muscularGroup;
    }

    public function setMuscularGroup(?MuscularGroup $muscularGroup): self
    {
        $this->muscularGroup = $muscularGroup;

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
            $workoutParameter->setExercice($this);
        }

        return $this;
    }

    public function removeWorkoutParameter(WorkoutParameter $workoutParameter): self
    {
        if ($this->workoutParameters->removeElement($workoutParameter)) {
            // set the owning side to null (unless already changed)
            if ($workoutParameter->getExercice() === $this) {
                $workoutParameter->setExercice(null);
            }
        }

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): self
    {
        $this->description = $description;

        return $this;
    }
}
