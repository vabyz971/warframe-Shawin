<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\LinkRepository")
 */
class Link
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $linked;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $disLinked;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Musique", inversedBy="links")
     */
    private $musiqueLink;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getLinked(): ?int
    {
        return $this->linked;
    }

    public function setLinked(?int $linked): self
    {
        $this->linked = $linked;

        return $this;
    }

    public function getDisLinked(): ?int
    {
        return $this->disLinked;
    }

    public function setDisLinked(?int $disLinked): self
    {
        $this->disLinked = $disLinked;

        return $this;
    }

    public function getMusiqueLink(): ?Musique
    {
        return $this->musiqueLink;
    }

    public function setMusiqueLink(?Musique $musiqueLink): self
    {
        $this->musiqueLink = $musiqueLink;

        return $this;
    }
}
