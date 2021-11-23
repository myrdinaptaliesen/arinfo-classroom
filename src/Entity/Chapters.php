<?php

namespace App\Entity;

use App\Repository\ChaptersRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=ChaptersRepository::class)
 */
class Chapters
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
    private $titleChapter;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $pictureChapter;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitleChapter(): ?string
    {
        return $this->titleChapter;
    }

    public function setTitleChapter(string $titleChapter): self
    {
        $this->titleChapter = $titleChapter;

        return $this;
    }

    public function getPictureChapter(): ?string
    {
        return $this->pictureChapter;
    }

    public function setPictureChapter(string $pictureChapter): self
    {
        $this->pictureChapter = $pictureChapter;

        return $this;
    }
}
