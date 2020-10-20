<?php

namespace App\Entity;

use App\Repository\MovieRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Knp\DoctrineBehaviors\Contract\Entity\SluggableInterface;
use Knp\DoctrineBehaviors\Model\Sluggable\SluggableTrait;

/**
 * @ORM\Entity(repositoryClass=MovieRepository::class)
 */
class Movie implements SluggableInterface
{
    use SluggableTrait;

    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $title;

    /**
     * @ORM\Column(type="date", nullable=true)
     */
    private $releaseDate;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $description;

    /**
     * @ORM\ManyToMany(targetEntity=Person::class, inversedBy="actorId")
     */
    private $casting;

    /**
     * @ORM\ManyToOne(targetEntity=Person::class, inversedBy="realisatorMovies", cascade={"persist"})
     */
    private $realisator;

    /**
     * @ORM\ManyToOne(targetEntity=Category::class, inversedBy="movies")
     */
    private $category;

    public function __construct()
    {
        $this->casting = new ArrayCollection();
    }

    /**
     * @return string[]
     */
    public function getSluggableFields(): array
    {
        return ['title'];
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

    public function getReleaseDate(): ?\DateTimeInterface
    {
        return $this->releaseDate;
    }

    public function setReleaseDate(?\DateTimeInterface $releaseDate): self
    {
        $this->releaseDate = $releaseDate;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): self
    {
        $this->description = $description;

        return $this;
    }

    /**
     * @return Collection|Person[]
     */
    public function getCasting(): Collection
    {
        return $this->casting;
    }

    public function addCasting(Person $casting): self
    {
        if (!$this->casting->contains($casting)) {
            $this->casting[] = $casting;
        }

        return $this;
    }

    public function removeCasting(Person $casting): self
    {
        if ($this->casting->contains($casting)) {
            $this->casting->removeElement($casting);
        }

        return $this;
    }

    public function getRealisator(): ?Person
    {
        return $this->realisator;
    }

    public function setRealisator(?Person $realisator): self
    {
        $this->realisator = $realisator;

        return $this;
    }

    public function getCategory(): ?Category
    {
        return $this->category;
    }

    public function setCategory(?Category $category): self
    {
        $this->category = $category;

        return $this;
    }
}
