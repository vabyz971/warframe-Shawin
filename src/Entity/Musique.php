<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\MusiqueRepository")
 */
class Musique
{

    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $title;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $description;

    /**
     * @ORM\Column(type="text")
     */
    private $code;

    /**
     * @ORM\Column(type="datetime")
     */
    private $created;

    /**
     * @ORM\Column(type="string", length=12)
     */
    private $difficulty;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\User", inversedBy="musiques")
     */
    private $idMusique;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Comment", mappedBy="musique", orphanRemoval=true)
     */
    private $commented;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Link", mappedBy="musiqueLink")
     */
    private $links;

    public function __construct(){
        $this->created = new \DateTime();
        $this->commented = new ArrayCollection();
        $this->links = new ArrayCollection();
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

        public function getDifficulty(): ?string
        {
            return $this->difficulty;
        }

        public function setDifficulty(string $difficulty): self
        {
            $this->difficulty = $difficulty;

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

    public function getCode(): ?string
    {
        return $this->code;
    }

    public function setCode(string $code): self
    {
        $this->code = $code;

        return $this;
    }

    public function getCreated(): ?\DateTimeInterface
    {
        return $this->created;
    }

    public function setCreated(\DateTimeInterface $created): self
    {
        $this->created = $created;

        return $this;
    }

    public function getIdMusique(): ?user
    {
        return $this->idMusique;
    }

    public function setIdMusique(?user $idMusique): self
    {
        $this->idMusique = $idMusique;

        return $this;
    }

    /**
     * @return Collection|Comment[]
     */
    public function getCommented(): Collection
    {
        return $this->commented;
    }

    public function addCommented(Comment $commented): self
    {
        if (!$this->commented->contains($commented)) {
            $this->commented[] = $commented;
            $commented->setMusique($this);
        }

        return $this;
    }

    public function removeCommented(Comment $commented): self
    {
        if ($this->commented->contains($commented)) {
            $this->commented->removeElement($commented);
            // set the owning side to null (unless already changed)
            if ($commented->getMusique() === $this) {
                $commented->setMusique(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Link[]
     */
    public function getLinks(): Collection
    {
        return $this->links;
    }

    public function addLink(Link $link): self
    {
        if (!$this->links->contains($link)) {
            $this->links[] = $link;
            $link->setMusiqueLink($this);
        }

        return $this;
    }

    public function removeLink(Link $link): self
    {
        if ($this->links->contains($link)) {
            $this->links->removeElement($link);
            // set the owning side to null (unless already changed)
            if ($link->getMusiqueLink() === $this) {
                $link->setMusiqueLink(null);
            }
        }

        return $this;
    }
}
