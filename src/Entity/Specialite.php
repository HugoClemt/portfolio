<?php

namespace App\Entity;

use App\Repository\SpecialiteRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=SpecialiteRepository::class)
 * @ORM\Table(name="`Specialite`")
 */
class Specialite
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=50, nullable=true)
     */
    private $sigle;

    /**
     * @ORM\Column(type="string", length=50, nullable=true)
     */
    private $libelle;

    /**
     * @ORM\OneToMany(targetEntity=DomaineTaches::class, mappedBy="specialites")
     */
    private $domaineTaches;

    /**
     * @ORM\OneToMany(targetEntity=Promotion::class, mappedBy="specialite")
     */
    private $promotion;

    public function __construct()
    {
        $this->etudiants = new ArrayCollection();
        $this->domaineTaches = new ArrayCollection();
        $this->promotion = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getSigle(): ?string
    {
        return $this->sigle;
    }

    public function setSigle(?string $sigle): self
    {
        $this->sigle = $sigle;

        return $this;
    }

    public function getLibelle(): ?string
    {
        return $this->libelle;
    }

    public function setLibelle(?string $libelle): self
    {
        $this->libelle = $libelle;

        return $this;
    }

    /**
     * @return Collection|DomaineTaches[]
     */
    public function getDomaineTaches(): Collection
    {
        return $this->domaineTaches;
    }

    public function addDomaineTach(DomaineTaches $domaineTach): self
    {
        if (!$this->domaineTaches->contains($domaineTach)) {
            $this->domaineTaches[] = $domaineTach;
            $domaineTach->setSpecialite($this);
        }

        return $this;
    }

    public function removeDomaineTach(DomaineTaches $domaineTach): self
    {
        if ($this->domaineTaches->removeElement($domaineTach)) {
            // set the owning side to null (unless already changed)
            if ($domaineTach->getSpecialite() === $this) {
                $domaineTach->setSpecialite(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Promotion[]
     */
    public function getPromotion(): Collection
    {
        return $this->promotion;
    }

    public function addPromotion(Promotion $promotion): self
    {
        if (!$this->promotion->contains($promotion)) {
            $this->promotion[] = $promotion;
            $promotion->setSpecialite($this);
        }

        return $this;
    }

    public function removePromotion(Promotion $promotion): self
    {
        if ($this->promotion->removeElement($promotion)) {
            // set the owning side to null (unless already changed)
            if ($promotion->getSpecialite() === $this) {
                $promotion->setSpecialite(null);
            }
        }

        return $this;
    }
}
