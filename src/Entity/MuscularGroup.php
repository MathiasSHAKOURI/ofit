<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use App\Repository\MuscularGroupRepository;
use Doctrine\Common\Collections\Collection;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * @ORM\Entity(repositoryClass=MuscularGroupRepository::class)
 */
class MuscularGroup
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     * @Groups({"exerciceIndex"})
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=50)
     * @Assert\Unique
     * @Assert\NotBlank
     * @Assert\Length(
     * min = 1,
     * max = 50,
     * minMessage = "Votre groupe musculaire doit comporter au moins {{ limit }} caractères",
     * maxMessage = "Votre groupe musculaire ne peut pas contenir plus de {{ limit }} caractères"
     * )
     * @Groups({"exerciceIndex"})
     */
    private $label;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     * @Assert\Url
     * @Assert\Length(
     * min = 1,
     * max = 255,
     * minMessage = "Votre url doit comporter au moins {{ limit }} caractères",
     * maxMessage = "Votre url ne peut pas contenir plus de {{ limit }} caractères"
     * )
     */
    private $picture;

    /**
     * @ORM\OneToMany(targetEntity=Exercice::class, mappedBy="muscularGroup", orphanRemoval=true)
     */
    private $exercices;

    /**
     * @ORM\Column(type="string", length=50)
     * @Assert\NotBlank
     * @Assert\Length(
     * min = 1,
     * max = 50
     * )
     */
    private $slug;

    public function __construct()
    {
        $this->exercices = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getLabel(): ?string
    {
        return $this->label;
    }

    public function setLabel(string $label): self
    {
        $this->label = $label;

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

    /**
     * @return Collection<int, Exercice>
     */
    public function getExercices(): Collection
    {
        return $this->exercices;
    }

    public function addExercice(Exercice $exercice): self
    {
        if (!$this->exercices->contains($exercice)) {
            $this->exercices[] = $exercice;
            $exercice->setMuscularGroup($this);
        }

        return $this;
    }

    public function removeExercice(Exercice $exercice): self
    {
        if ($this->exercices->removeElement($exercice)) {
            // set the owning side to null (unless already changed)
            if ($exercice->getMuscularGroup() === $this) {
                $exercice->setMuscularGroup(null);
            }
        }

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
}
