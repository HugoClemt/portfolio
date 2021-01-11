<?php

namespace App\Entity;

use App\Repository\NiveauRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=NiveauRepository::class)
 */
class Niveau
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=50)
     */
    private $libelle;

    /**
     * @ORM\OneToMany(targetEntity=RP::class, mappedBy="niveau")
     */
    private $RPs;

    public function __construct()
    {
        $this->activites = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getLibelle(): ?string
    {
        return $this->libelle;
    }

    public function setLibelle(string $libelle): self
    {
        $this->libelle = $libelle;

        return $this;
    }

    /**
     * @return Collection|RP[]
     */
    public function getRPs(): Collection
    {
        return $this->rps;
    }

    public function addRP(RP $rp): self
    {
        if (!$this->rps->contains($rp)) {
            $this->rps[] = $rp;
            $rp->setNiveau($this);
        }

        return $this;
    }

    public function removeRP(RP $rp): self
    {
        if ($this->rps->removeElement($rp)) {
            // set the owning side to null (unless already changed)
            if ($rp->getNiveau() === $this) {
                $rp->setNiveau(null);
            }
        }

        return $this;
    }
}
