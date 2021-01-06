<?php

namespace App\Entity;

use App\Repository\OptionIRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=OptionIRepository::class)
 * @ORM\Table(name="`option_I`")
 */
class OptionI
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
     * @ORM\OneToMany(targetEntity=DomaineTaches::class, mappedBy="options")
     */
    private $domaineTaches;

    /**
     * @ORM\OneToMany(targetEntity=Promotion::class, mappedBy="optioni")
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
            $domaineTach->setOptions($this);
        }

        return $this;
    }

    public function removeDomaineTach(DomaineTaches $domaineTach): self
    {
        if ($this->domaineTaches->removeElement($domaineTach)) {
            // set the owning side to null (unless already changed)
            if ($domaineTach->getOptions() === $this) {
                $domaineTach->setOptions(null);
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
            $promotion->setOptioni($this);
        }

        return $this;
    }

    public function removePromotion(Promotion $promotion): self
    {
        if ($this->promotion->removeElement($promotion)) {
            // set the owning side to null (unless already changed)
            if ($promotion->getOptioni() === $this) {
                $promotion->setOptioni(null);
            }
        }

        return $this;
    }
}
