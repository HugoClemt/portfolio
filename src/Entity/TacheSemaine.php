<?php

namespace App\Entity;

use App\Repository\TacheSemaineRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=TacheSemaineRepository::class)
 */
class TacheSemaine
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $duree;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $description;

    /**
     * @ORM\ManyToOne(targetEntity=DomaineTaches::class, inversedBy="tacheSemaines")
     */
    private $domaine;

    /**
     * @ORM\ManyToOne(targetEntity=Jour::class, inversedBy="tacheSemaines")
     * @ORM\OrderBy({"jour" = "ASC"})
     */
    private $jour;

    /**
     * @ORM\ManyToOne(targetEntity=SemaineStage::class, inversedBy="tacheSemaines")
     */
    private $semaineStage;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDuree(): ?int
    {
        return $this->duree;
    }

    public function setDuree(?int $duree): self
    {
        $this->duree = $duree;

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

    public function getDomaine(): ?DomaineTaches
    {
        return $this->domaine;
    }

    public function setDomaine(?DomaineTaches $domaine): self
    {
        $this->domaine = $domaine;

        return $this;
    }

    public function getJour(): ?Jour
    {
        return $this->jour;
    }

    public function setJour(?Jour $jour): self
    {
        $this->jour = $jour;

        return $this;
    }

    public function getSemaineStage(): ?SemaineStage
    {
        return $this->semaineStage;
    }

    public function setSemaineStage(?SemaineStage $semaineStage): self
    {
        $this->semaineStage = $semaineStage;

        return $this;
    }
}
