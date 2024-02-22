<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use App\Repository\WorkoutParameterRepository;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Validator\Context\ExecutionContextInterface;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * @ORM\Entity(repositoryClass=WorkoutParameterRepository::class)
 */
class WorkoutParameter
{
    /**
     * @Assert\Callback
     */
    public function validateRepsOrDuration(ExecutionContextInterface $context, $payload)
    {
        if ($this->reps === null && $this->duration === null) {
            $context->buildViolation("Vous devez spécifier au moins l'une des deux propriétés : répétition ou durée.")
                ->atPath('reps')
                ->addViolation();
        } elseif ($this->reps !== null && $this->duration !== null) {
            $context->buildViolation("Vous ne pouvez spécifier que l'une des deux propriétés : répétition ou durée, pas les deux.")
                ->atPath('reps')
                ->addViolation();
        }
    }
    
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    const REPS = [4,6,8,10,12,14,16,18,20];

    /**
     * @ORM\Column(type="integer", nullable=true)
     * @Assert\Positive
     * @Assert\Type(
     *     type="integer",
     *     message="La {{ value }} n'est pas un entier."
     * )
     * @Assert\Choice(choices=WorkoutParameter::REPS, message="Veuillez choisir un nombre de répétitions valide.")
     */
    private $reps;

    const DURATION = [15,30,45,60,90,120];

    /**
     * @ORM\Column(type="integer", nullable=true)
     * @Assert\Positive
     * @Assert\Type(
     *     type="integer",
     *     message="La {{ value }} n'est pas un entier."
     * )
     * @Assert\Choice(choices=WorkoutParameter::DURATION, message="Veuillez choisir une durée valide.")
     */
    private $duration;

    /**
     * @ORM\Column(type="integer")
     * @Assert\NotBlank
     * @Assert\Positive
     * @Assert\Type(
     *     type="integer",
     *     message="La {{ value }} n'est pas un entier."
     * )
     * @Assert\Range(
     *      min = 1,
     *      max = 20,
     *      notInRangeMessage = "La valeur doit être comprise entre 1 et 20."
     * )
     */
    private $sets;

    const REST = [15,30,45,60,90,120];

    /**
     * @ORM\Column(type="integer")
     * @Assert\NotBlank
     * @Assert\Positive
     * @Assert\Type(
     *     type="integer",
     *     message="La {{ value }} n'est pas un entier."
     * )
     * @Assert\Choice(choices=WorkoutParameter::REST, message="Veuillez choisir un temps de repos valide.")
     */
    private $rest;

    /**
     * @ORM\ManyToOne(targetEntity=Exercice::class, inversedBy="workoutParameters")
     * @ORM\JoinColumn(nullable=false)
     * @Groups({"workoutIndex"})
     */
    private $exercice;

    /**
     * @ORM\ManyToOne(targetEntity=WorkoutProgram::class, inversedBy="workoutParameters")
     * @ORM\JoinColumn(nullable=false)
     */
    private $workoutProgram;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getReps(): ?int
    {
        return $this->reps;
    }

    public function setReps(?int $reps): self
    {
        $this->reps = $reps;

        return $this;
    }

    public function getDuration(): ?int
    {
        return $this->duration;
    }

    public function setDuration(?int $duration): self
    {
        $this->duration = $duration;

        return $this;
    }

    public function getSets(): int
    {
        return $this->sets;
    }

    public function setSets(int $sets): self
    {
        $this->sets = $sets;

        return $this;
    }

    public function getRest(): int
    {
        return $this->rest;
    }

    public function setRest(int $rest): self
    {
        $this->rest = $rest;

        return $this;
    }

    public function getExercice(): ?Exercice
    {
        return $this->exercice;
    }

    public function setExercice(?Exercice $exercice): self
    {
        $this->exercice = $exercice;

        return $this;
    }

    public function getWorkoutProgram(): ?WorkoutProgram
    {
        return $this->workoutProgram;
    }

    public function setWorkoutProgram(?WorkoutProgram $workoutProgram): self
    {
        $this->workoutProgram = $workoutProgram;

        return $this;
    }
}
