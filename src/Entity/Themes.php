<?php

namespace App\Entity;

use App\Repository\ThemesRepository;
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
}
