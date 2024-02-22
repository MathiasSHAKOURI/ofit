<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use App\Repository\UserRepository;
use Doctrine\Common\Collections\Collection;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Serializer\Annotation\Groups;


/**
 * @ORM\Entity(repositoryClass=UserRepository::class)
 * @UniqueEntity(fields={"email"}, message="Il y a déjà un compte avec cet email.")
 */
class User implements UserInterface, PasswordAuthenticatedUserInterface
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     * @Groups({"coachIndex", "articleIndex", "workoutIndex"})
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=180, unique=true)
     * @Assert\Email
     * @Assert\Length(
     * min = 7,
     * max = 180,
     * minMessage = "Votre email doit comporter au moins {{ limit }} caractères",
     * maxMessage = "Votre email ne peut pas contenir plus de {{ limit }} caractères"
     * )
     */
    private $email;

    /**
     * @ORM\Column(type="json")
     */
    private $roles = [];

    /**
     * @var string The hashed password
     * @ORM\Column(type="string")
     * @Assert\NotBlank
     * @Assert\Regex(
     *     pattern="/^(?=.*[a-z])(?=.*[A-Z])(?=.*[\W_]).{12,}$/",
     *     message="Vous n'avez pas respecté la complexité requise pour le mot de passe."
     * )
     */
    private $password;

    /**
     * @ORM\Column(type="string", length=50, nullable=true)
     * @Assert\Type("string")
     * @Assert\Length(
     * min = 1,
     * max = 50,
     * minMessage = "Votre pseudo doit comporter au moins {{ limit }} caractères",
     * maxMessage = "Votre pseudo ne peut pas contenir plus de {{ limit }} caractères"
     * )
     * @Groups({"exerciceIndex", "articleIndex", "workoutIndex"})
     */
    private $pseudo;

    /**
     * @ORM\Column(type="string", length=50)
     * @Assert\NotBlank
     * @Assert\Type("string")
     * @Assert\Regex(
     *     pattern="/^[a-zA-Z\s]+$/",
     *     message="Le prénom doit contenir uniquement des lettres et ne pas contenir de chiffres."
     * )
     * @Assert\Length(
     * min = 1,
     * max = 100,
     * minMessage = "Votre prénom doit comporter au moins {{ limit }} caractères",
     * maxMessage = "Votre prénom ne peut pas contenir plus de {{ limit }} caractères"
     * )
     * @Groups({"coachIndex"})
     */
    private $firstname;

    /**
     * @ORM\Column(type="string", length=50)
     * @Assert\NotBlank
     * @Assert\Type("string")
     * @Assert\Regex(
     *     pattern="/^[a-zA-Z\s]+$/",
     *     message="Le nom doit contenir uniquement des lettres et ne pas contenir de chiffres."
     * )
     * @Assert\Length(
     * min = 1,
     * max = 100,
     * minMessage = "Votre nom doit comporter au moins {{ limit }} caractères",
     * maxMessage = "Votre nom ne peut pas contenir plus de {{ limit }} caractères"
     * )
     * @Groups({"coachIndex"})
     */
    private $lastname;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     * @Assert\Url
     * @Assert\Length(
     * min = 1,
     * max = 255,
     * minMessage = "Votre url doit comporter au moins {{ limit }} caractères",
     * maxMessage = "Votre url ne peut pas contenir plus de {{ limit }} caractères"
     * )
     * @Groups({"coachIndex"})
     */
    private $picture;

    /**
     * @ORM\Column(type="text", nullable=true)
     * @Assert\Length(
     * min = 100,
     * max = 65535,
     * minMessage = "Votre présentation doit comporter au moins {{ limit }} caractères",
     * maxMessage = "Votre présentation ne peut pas contenir plus de {{ limit }} caractères"
     * )
     * @Groups({"coachIndex"})
     */
    private $presentation;

    /**
     * @ORM\OneToMany(targetEntity=WorkoutProgram::class, mappedBy="user")
     */
    private $workoutPrograms;

    /**
     * @ORM\OneToMany(targetEntity=Article::class, mappedBy="user")
     */
    private $articles;

    /**
     * @ORM\Column(type="boolean")
     */
    private $isVerified = false;

    public function __construct()
    {
        $this->workoutPrograms = new ArrayCollection();
        $this->articles = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getEmail(): string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }

    /**
     * A visual identifier that represents this user.
     *
     * @see UserInterface
     */
    public function getUserIdentifier(): string
    {
        return (string) $this->email;
    }

    /**
     * @deprecated since Symfony 5.3, use getUserIdentifier instead
     */
    public function getUsername(): string
    {
        return (string) $this->email;
    }

    /**
     * @see UserInterface
     */
    public function getRoles(): array
    {
        $roles = $this->roles;
        // guarantee every user at least has ROLE_USER
        // $roles[] = 'ROLE_USER';

        return array_unique($roles);
    }

    public function setRoles(array $roles): self
    {
        $this->roles = $roles;

        return $this;
    }

    /**
     * @see PasswordAuthenticatedUserInterface
     */
    public function getPassword(): string
    {
        return $this->password;
    }

    public function setPassword(string $password): self
    {
        $this->password = $password;

        return $this;
    }

    /**
     * Returning a salt is only needed, if you are not using a modern
     * hashing algorithm (e.g. bcrypt or sodium) in your security.yaml.
     *
     * @see UserInterface
     */
    public function getSalt(): ?string
    {
        return null;
    }

    /**
     * @see UserInterface
     */
    public function eraseCredentials()
    {
        // If you store any temporary, sensitive data on the user, clear it here
        // $this->plainPassword = null;
    }

    public function getPseudo(): ?string
    {
        return $this->pseudo;
    }

    public function setPseudo(?string $pseudo): self
    {
        $this->pseudo = $pseudo;

        return $this;
    }

    public function getFirstname(): string
    {
        return $this->firstname;
    }

    public function setFirstname(string $firstname): self
    {
        $this->firstname = $firstname;

        return $this;
    }

    public function getLastname(): string
    {
        return $this->lastname;
    }

    public function setLastname(string $lastname): self
    {
        $this->lastname = $lastname;

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

    public function getPresentation(): ?string
    {
        return $this->presentation;
    }

    public function setPresentation(?string $presentation): self
    {
        $this->presentation = $presentation;

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
            $workoutProgram->setUser($this);
        }

        return $this;
    }

    public function removeWorkoutProgram(WorkoutProgram $workoutProgram): self
    {
        if ($this->workoutPrograms->removeElement($workoutProgram)) {
            // set the owning side to null (unless already changed)
            if ($workoutProgram->getUser() === $this) {
                $workoutProgram->setUser(null);
            }
        }

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
            $article->setUser($this);
        }

        return $this;
    }

    public function removeArticle(Article $article): self
    {
        if ($this->articles->removeElement($article)) {
            // set the owning side to null (unless already changed)
            if ($article->getUser() === $this) {
                $article->setUser(null);
            }
        }

        return $this;
    }

    public function isVerified(): bool
    {
        return $this->isVerified;
    }

    public function setIsVerified(bool $isVerified): self
    {
        $this->isVerified = $isVerified;

        return $this;
    }
}
