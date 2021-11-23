<?php

namespace App\Entity;

use App\Repository\SubChaptersRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=SubChaptersRepository::class)
 */
class SubChapters
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $titleSubChapter;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $videoSubChapter;

    /**
     * @ORM\ManyToOne(targetEntity=Chapters::class, inversedBy="subChapters")
     */
    private $chapters;

    /**
     * @ORM\OneToMany(targetEntity=Exercices::class, mappedBy="subChapters")
     */
    private $exercices;

    public function __construct()
    {
        $this->exercices = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitleSubChapter(): ?string
    {
        return $this->titleSubChapter;
    }

    public function setTitleSubChapter(string $titleSubChapter): self
    {
        $this->titleSubChapter = $titleSubChapter;

        return $this;
    }

    public function getVideoSubChapter(): ?string
    {
        return $this->videoSubChapter;
    }

    public function setVideoSubChapter(string $videoSubChapter): self
    {
        $this->videoSubChapter = $videoSubChapter;

        return $this;
    }

    public function getChapters(): ?Chapters
    {
        return $this->chapters;
    }

    public function setChapters(?Chapters $chapters): self
    {
        $this->chapters = $chapters;

        return $this;
    }

    /**
     * @return Collection|Exercices[]
     */
    public function getExercices(): Collection
    {
        return $this->exercices;
    }

    public function addExercice(Exercices $exercice): self
    {
        if (!$this->exercices->contains($exercice)) {
            $this->exercices[] = $exercice;
            $exercice->setSubChapters($this);
        }

        return $this;
    }

    public function removeExercice(Exercices $exercice): self
    {
        if ($this->exercices->removeElement($exercice)) {
            // set the owning side to null (unless already changed)
            if ($exercice->getSubChapters() === $this) {
                $exercice->setSubChapters(null);
            }
        }

        return $this;
    }
}
