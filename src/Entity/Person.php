<?php

namespace App\Entity;

use App\Repository\PersonRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=PersonRepository::class)
 */
class Person
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=50)
     */
    private $firstName;

    /**
     * @ORM\Column(type="string", length=50)
     */
    private $lastName;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $biography;

    /**
     * @ORM\ManyToMany(targetEntity=Movie::class, mappedBy="casting")
     */
    private $actorId;

    /**
     * @ORM\OneToMany(targetEntity=Movie::class, mappedBy="realisator")
     */
    private $realisatorMovies;

    public function __construct()
    {
        $this->actorId = new ArrayCollection();
        $this->realisatorMovies = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getFirstName(): ?string
    {
        return $this->firstName;
    }

    public function setFirstName(string $firstName): self
    {
        $this->firstName = $firstName;

        return $this;
    }

    public function getLastName(): ?string
    {
        return $this->lastName;
    }

    public function setLastName(string $lastName): self
    {
        $this->lastName = $lastName;

        return $this;
    }

    public function getBiography(): ?string
    {
        return $this->biography;
    }

    public function setBiography(?string $biography): self
    {
        $this->biography = $biography;

        return $this;
    }

    /**
     * @return Collection|Movie[]
     */
    public function getActorId(): Collection
    {
        return $this->actorId;
    }

    public function addActorId(Movie $actorId): self
    {
        if (!$this->actorId->contains($actorId)) {
            $this->actorId[] = $actorId;
            $actorId->addCasting($this);
        }

        return $this;
    }

    public function removeActorId(Movie $actorId): self
    {
        if ($this->actorId->contains($actorId)) {
            $this->actorId->removeElement($actorId);
            $actorId->removeCasting($this);
        }

        return $this;
    }

    /**
     * @return Collection|Movie[]
     */
    public function getRealisatorMovies(): Collection
    {
        return $this->realisatorMovies;
    }

    public function addRealisatorMovies(Movie $realisatorMovies): self
    {
        if (!$this->realisatorMovies->contains($realisatorMovies)) {
            $this->realisatorMovies[] = $realisatorMovies;
            $realisatorMovies->setRealisator($this);
        }

        return $this;
    }

    public function removeRealisatorMovies(Movie $realisatorMovies): self
    {
        if ($this->realisatorMovies->contains($realisatorMovies)) {
            $this->realisatorMovies->removeElement($realisatorMovies);
            // set the owning side to null (unless already changed)
            if ($realisatorMovies->getRealisator() === $this) {
                $realisatorMovies->setRealisator(null);
            }
        }

        return $this;
    }
}
