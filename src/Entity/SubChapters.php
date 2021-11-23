<?php

namespace App\Entity;

use App\Repository\SubChaptersRepository;
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
}
