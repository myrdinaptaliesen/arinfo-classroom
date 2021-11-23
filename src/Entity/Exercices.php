<?php

namespace App\Entity;

use App\Repository\ExercicesRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=ExercicesRepository::class)
 */
class Exercices
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
    private $titleExercise;

    /**
     * @ORM\Column(type="text")
     */
    private $descriptionExercice;

    /**
     * @ORM\ManyToOne(targetEntity=SubChapters::class, inversedBy="exercices")
     */
    private $subChapters;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitleExercise(): ?string
    {
        return $this->titleExercise;
    }

    public function setTitleExercise(string $titleExercise): self
    {
        $this->titleExercise = $titleExercise;

        return $this;
    }

    public function getDescriptionExercice(): ?string
    {
        return $this->descriptionExercice;
    }

    public function setDescriptionExercice(string $descriptionExercice): self
    {
        $this->descriptionExercice = $descriptionExercice;

        return $this;
    }

    public function getSubChapters(): ?SubChapters
    {
        return $this->subChapters;
    }

    public function setSubChapters(?SubChapters $subChapters): self
    {
        $this->subChapters = $subChapters;

        return $this;
    }
}
