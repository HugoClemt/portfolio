<?php

namespace App\Entity;

use App\Repository\DomaineTachesRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=DomaineTachesRepository::class)
 */
class DomaineTaches
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=100, nullable=true)
     */
    private $libelle;

    /**
     * @ORM\OneToMany(targetEntity=TacheSemaine::class, mappedBy="domaine")
     */
    private $tacheSemaines;

    public function __construct()
    {
        $this->tacheSemaines = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
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


    public function getOptions(): ?OptionI
    {
        return $this->options;
    }

    public function setOptions(?OptionI $options): self
    {
        $this->options = $options;

        return $this;
    }

    /**
     * @return Collection|TacheSemaine[]
     */
    public function getTacheSemaines(): Collection
    {
        return $this->tacheSemaines;
    }

    public function addTacheSemaine(TacheSemaine $tacheSemaine): self
    {
        if (!$this->tacheSemaines->contains($tacheSemaine)) {
            $this->tacheSemaines[] = $tacheSemaine;
            $tacheSemaine->setDomaine($this);
        }

        return $this;
    }

    public function removeTacheSemaine(TacheSemaine $tacheSemaine): self
    {
        if ($this->tacheSemaines->removeElement($tacheSemaine)) {
            // set the owning side to null (unless already changed)
            if ($tacheSemaine->getDomaine() === $this) {
                $tacheSemaine->setDomaine(null);
            }
        }

        return $this;
    }
}
