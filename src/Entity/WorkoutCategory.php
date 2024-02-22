<?php

namespace App\Entity;

use App\Repository\WorkoutCategoryRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * @ORM\Entity(repositoryClass=WorkoutCategoryRepository::class)
 */
class WorkoutCategory
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     * @Groups({"workoutIndex"})
     */
    private $id;

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
     * @Groups({"workoutIndex"})
     */
    private $label;

    /**
     * @ORM\OneToMany(targetEntity=WorkoutProgram::class, mappedBy="workoutCategory")
     */
    private $workoutPrograms;

    public function __construct()
    {
        $this->workoutPrograms = new ArrayCollection();
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
     * @return Collection<int, WorkoutProgram>
     */
    public function getWorkoutPrograms(): Collection
    {
        return $this->workoutPrograms;
    }

    public function addWorkoutProgram(WorkoutProgram $workoutProgram): self
    {
        if (!$this->workoutPrograms->contains($workoutProgram)) {
            $this->workoutPrograms[] = $workoutProgram;
            $workoutProgram->setWorkoutCategory($this);
        }

        return $this;
    }

    public function removeWorkoutProgram(WorkoutProgram $workoutProgram): self
    {
        if ($this->workoutPrograms->removeElement($workoutProgram)) {
            // set the owning side to null (unless already changed)
            if ($workoutProgram->getWorkoutCategory() === $this) {
                $workoutProgram->setWorkoutCategory(null);
            }
        }

        return $this;
    }
}
