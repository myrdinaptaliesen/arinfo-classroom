<?php

namespace App\Entity;

use App\Repository\ThemesRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=ThemesRepository::class)
 */
class Themes
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
    private $titleTheme;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $pictureTheme;

    /**
     * @ORM\OneToMany(targetEntity=Chapters::class, mappedBy="themes")
     */
    private $chapters;

    public function __construct()
    {
        $this->chapters = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitleTheme(): ?string
    {
        return $this->titleTheme;
    }

    public function setTitleTheme(string $titleTheme): self
    {
        $this->titleTheme = $titleTheme;

        return $this;
    }

    public function getPictureTheme(): ?string
    {
        return $this->pictureTheme;
    }

    public function setPictureTheme(string $pictureTheme): self
    {
        $this->pictureTheme = $pictureTheme;

        return $this;
    }

    /**
     * @return Collection|Chapters[]
     */
    public function getChapters(): Collection
    {
        return $this->chapters;
    }

    public function addChapter(Chapters $chapter): self
    {
        if (!$this->chapters->contains($chapter)) {
            $this->chapters[] = $chapter;
            $chapter->setThemes($this);
        }

        return $this;
    }

    public function removeChapter(Chapters $chapter): self
    {
        if ($this->chapters->removeElement($chapter)) {
            // set the owning side to null (unless already changed)
            if ($chapter->getThemes() === $this) {
                $chapter->setThemes(null);
            }
        }

        return $this;
    }
}
