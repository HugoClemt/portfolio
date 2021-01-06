<?php

namespace App\Entity;

use App\Repository\ActiviteRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=ActiviteRepository::class)
 */
class Activite
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=10)
     */
    private $code;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $libelle;

    /**
     * @ORM\OneToMany(targetEntity=Competence::class, mappedBy="activite")
     */
    private $competences;

    /**
     * @ORM\ManyToOne(targetEntity=Bloc::class, inversedBy="activites")
     * @ORM\JoinColumn(nullable=false)
     */
    private $bloc;

    /**
     * @ORM\OneToMany(targetEntity=RPActivite::class, mappedBy="activite")
     */
    private $RPs;

    public function __construct()
    {
        $this->competences = new ArrayCollection();
        $this->RPs = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
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
     * @return Collection|Competence[]
     */
    public function getCompetences(): Collection
    {
        return $this->competences;
    }

    public function addCompetence(Competence $competence): self
    {
        if (!$this->competences->contains($competence)) {
            $this->competences[] = $competence;
            $competence->setActivite($this);
        }

        return $this;
    }

    public function removeCompetence(Competence $competence): self
    {
        if ($this->competences->removeElement($competence)) {
            // set the owning side to null (unless already changed)
            if ($competence->getActivite() === $this) {
                $competence->setActivite(null);
            }
        }

        return $this;
    }

    public function getBloc(): ?Bloc
    {
        return $this->bloc;
    }

    public function setBloc(?Bloc $bloc): self
    {
        $this->bloc = $bloc;

        return $this;
    }

    /**
     * @return Collection|RPActivite[]
     */
    public function getRPs(): Collection
    {
        return $this->RPs;
    }

    public function addRP(RPActivite $rP): self
    {
        if (!$this->RPs->contains($rP)) {
            $this->RPs[] = $rP;
            $rP->setActivite($this);
        }

        return $this;
    }

    public function removeRP(RPActivite $rP): self
    {
        if ($this->RPs->removeElement($rP)) {
            // set the owning side to null (unless already changed)
            if ($rP->getActivite() === $this) {
                $rP->setActivite(null);
            }
        }

        return $this;
    }
}
