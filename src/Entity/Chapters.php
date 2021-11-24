<?php

namespace App\Entity;

use App\Repository\ChaptersRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;

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

    /**
     * @ORM\ManyToOne(targetEntity=Themes::class, inversedBy="chapters")
     */
    private $themes;

    /**
     * @ORM\OneToMany(targetEntity=SubChapters::class, mappedBy="chapters")
     */
    private $subChapters;

    /**
     * @Gedmo\Slug(fields={"titleChapter"})
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $slug;

    public function __construct()
    {
        $this->subChapters = new ArrayCollection();
    }

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

    public function getThemes(): ?Themes
    {
        return $this->themes;
    }

    public function setThemes(?Themes $themes): self
    {
        $this->themes = $themes;

        return $this;
    }

    /**
     * @return Collection|SubChapters[]
     */
    public function getSubChapters(): Collection
    {
        return $this->subChapters;
    }

    public function addSubChapter(SubChapters $subChapter): self
    {
        if (!$this->subChapters->contains($subChapter)) {
            $this->subChapters[] = $subChapter;
            $subChapter->setChapters($this);
        }

        return $this;
    }

    public function removeSubChapter(SubChapters $subChapter): self
    {
        if ($this->subChapters->removeElement($subChapter)) {
            // set the owning side to null (unless already changed)
            if ($subChapter->getChapters() === $this) {
                $subChapter->setChapters(null);
            }
        }

        return $this;
    }

    public function getSlug(): ?string
    {
        return $this->slug;
    }


}
