<?php

namespace App\Entity;

use App\Repository\SemaineStageRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=SemaineStageRepository::class)
 */
class SemaineStage
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
    private $numSemaine;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $apprentissage;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $bilan;

    /**
     * @ORM\OneToMany(targetEntity=TacheSemaine::class, mappedBy="semaineStage")
     */
    private $tacheSemaines;

    /**
     * @ORM\ManyToOne(targetEntity=Stage::class, inversedBy="semaineStages")
     */
    private $stage;

    /**
     * @ORM\OneToMany(targetEntity=Pointage::class, mappedBy="semaine")
     */
    private $pointages;

    public function __construct()
    {
        $this->tacheSemaines = new ArrayCollection();
        $this->pointages = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNumSemaine(): ?int
    {
        return $this->numSemaine;
    }

    public function setNumSemaine(?int $numSemaine): self
    {
        $this->numSemaine = $numSemaine;

        return $this;
    }

    public function getApprentissage(): ?string
    {
        return $this->apprentissage;
    }

    public function setApprentissage(?string $apprentissage): self
    {
        $this->apprentissage = $apprentissage;

        return $this;
    }

    public function getBilan(): ?string
    {
        return $this->bilan;
    }

    public function setBilan(?string $bilan): self
    {
        $this->bilan = $bilan;

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
            $tacheSemaine->setSemaineStage($this);
        }

        return $this;
    }

    public function removeTacheSemaine(TacheSemaine $tacheSemaine): self
    {
        if ($this->tacheSemaines->removeElement($tacheSemaine)) {
            // set the owning side to null (unless already changed)
            if ($tacheSemaine->getSemaineStage() === $this) {
                $tacheSemaine->setSemaineStage(null);
            }
        }

        return $this;
    }

    public function getStage(): ?Stage
    {
        return $this->stage;
    }

    public function setStage(?Stage $stage): self
    {
        $this->stage = $stage;

        return $this;
    }

    /**
     * @return Collection|Pointage[]
     */
    public function getPointages(): Collection
    {
        return $this->pointages;
    }

    public function addPointage(Pointage $pointage): self
    {
        if (!$this->pointages->contains($pointage)) {
            $this->pointages[] = $pointage;
            $pointage->setSemaine($this);
        }

        return $this;
    }

    public function removePointage(Pointage $pointage): self
    {
        if ($this->pointages->removeElement($pointage)) {
            // set the owning side to null (unless already changed)
            if ($pointage->getSemaine() === $this) {
                $pointage->setSemaine(null);
            }
        }

        return $this;
    }
}
