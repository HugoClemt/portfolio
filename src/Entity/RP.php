<?php

namespace App\Entity;

use App\Repository\RPRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=RPRepository::class)
 */
class RP
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=100)
     * @ORM\OrderBy({"order" = "ASC", "id" = "ASC"})
     */
    private $libcourt;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $besoin;

    /**
     * @ORM\Column(type="date")
     */
    private $dateDebut;

    /**
     * @ORM\Column(type="date")
     */
    private $dateFin;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $environnement;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $moyen;

    /**
     * @ORM\Column(type="date", nullable=true)
     */
    private $dateModif;

    /**
     * @ORM\OneToMany(targetEntity=RPActivite::class, mappedBy="rp")
     */
    private $activites;

    /**
     * @ORM\OneToMany(targetEntity=Commentaire::class, mappedBy="rp")
     */
    private $commentaire;

    /**
     * @ORM\ManyToOne(targetEntity=Localisation::class, inversedBy="RPs")
     */
    private $localisation;

    /**
     * @ORM\ManyToOne(targetEntity=Statut::class, inversedBy="RPs")
     */
    private $statut;

    /**
     * @ORM\ManyToOne(targetEntity=Source::class, inversedBy="RPs")
     * @ORM\JoinColumn(nullable=false)
     */
    private $source;

    /**
     * @ORM\ManyToOne(targetEntity=Etudiant::class, inversedBy="RPs")
     * @ORM\JoinColumn(nullable=false)
     */
    private $etudiant;

    /**
     * @ORM\ManyToOne(targetEntity=Enseignant::class, inversedBy="RPs")
     */
    private $enseignant;

    /**
     * @ORM\ManyToOne(targetEntity=Cadre::class, inversedBy="RPs")
     */
    private $cadre;

    /**
     * @ORM\ManyToOne(targetEntity=Niveau::class, inversedBy="RPs")
     */
    private $niveau;

    /**
     * @ORM\OneToMany(targetEntity=Production::class, mappedBy="rp")
     */
    private $productions;

    /**
     * @ORM\Column(type="boolean", nullable=true)
     */
    private $archivage;

    public function __construct()
    {
        $this->activites = new ArrayCollection();
        $this->commentaire = new ArrayCollection();
        $this->productions = new ArrayCollection();
  
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getLibcourt(): ?string
    {
        return $this->libcourt;
    }

    public function setLibcourt(string $libcourt): self
    {
        $this->libcourt = $libcourt;

        return $this;
    }

    public function getBesoin(): ?string
    {
        return $this->besoin;
    }

    public function setBesoin(?string $besoin): self
    {
        $this->besoin = $besoin;

        return $this;
    }


    public function getDateDebut(): ?\DateTimeInterface
    {
        return $this->dateDebut;
    }

    public function setDateDebut(\DateTimeInterface $dateDebut): self
    {
        $this->dateDebut = $dateDebut;

        return $this;
    }

    public function getDateFin(): ?\DateTimeInterface
    {
        return $this->dateFin;
    }

    public function setDateFin(\DateTimeInterface $dateFin): self
    {
        $this->dateFin = $dateFin;

        return $this;
    }

    public function getEnvironnement(): ?string
    {
        return $this->environnement;
    }

    public function setEnvironnement(?string $environnement): self
    {
        $this->environnement = $environnement;

        return $this;
    }

    public function getMoyen(): ?string
    {
        return $this->moyen;
    }

    public function setMoyen(?string $moyen): self
    {
        $this->moyen = $moyen;

        return $this;
    }

    public function getDateModif(): ?\DateTimeInterface
    {
        return $this->dateModif;
    }

    public function setDateModif(?\DateTimeInterface $dateModif): self
    {
        $this->dateModif = $dateModif;

        return $this;
    }

    /**
     * @return Collection|RPActivite[]
     */
    public function getActivites(): Collection
    {
        return $this->activites;
    }

    public function addActivite(RPActivite $activite): self
    {
        if (!$this->activites->contains($activite)) {
            $this->activites[] = $activite;
            $activite->setRp($this);
        }

        return $this;
    }

    public function removeActivite(RPActivite $activite): self
    {
        if ($this->activites->removeElement($activite)) {
            // set the owning side to null (unless already changed)
            if ($activite->getRp() === $this) {
                $activite->setRp(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Commentaire[]
     */
    public function getCommentaire(): Collection
    {
        return $this->commentaire;
    }

    public function addCommentaire(Commentaire $commentaire): self
    {
        if (!$this->commentaire->contains($commentaire)) {
            $this->commentaire[] = $commentaire;
            $commentaire->setRp($this);
        }

        return $this;
    }

    public function removeCommentaire(Commentaire $commentaire): self
    {
        if ($this->commentaire->removeElement($commentaire)) {
            // set the owning side to null (unless already changed)
            if ($commentaire->getRp() === $this) {
                $commentaire->setRp(null);
            }
        }

        return $this;
    }

    public function getLocalisation(): ?Localisation
    {
        return $this->localisation;
    }

    public function setLocalisation(?Localisation $localisation): self
    {
        $this->localisation = $localisation;

        return $this;
    }

    public function getStatut(): ?Statut
    {
        return $this->statut;
    }

    public function setStatut(?Statut $statut): self
    {
        $this->statut = $statut;

        return $this;
    }

    public function getSource(): ?Source
    {
        return $this->source;
    }

    public function setSource(?Source $source): self
    {
        $this->source = $source;

        return $this;
    }

    public function getEtudiant(): ?Etudiant
    {
        return $this->etudiant;
    }

    public function setEtudiant(?Etudiant $etudiant): self
    {
        $this->etudiant = $etudiant;

        return $this;
    }

    public function getEnseignant(): ?Enseignant
    {
        return $this->enseignant;
    }

    public function setEnseignant(?Enseignant $enseignant): self
    {
        $this->enseignant = $enseignant;

        return $this;
    }

    public function getCadre(): ?Cadre
    {
        return $this->cadre;
    }

    public function setCadre(?Cadre $cadre): self
    {
        $this->cadre = $cadre;

        return $this;
    }

    public function getNiveau(): ?Niveau
    {
        return $this->niveau;
    }

    public function setNiveau(?Niveau $niveau): self
    {
        $this->niveau = $niveau;

        return $this;
    }

    /**
     * @return Collection|Production[]
     */
    public function getProductions(): Collection
    {
        return $this->productions;
    }

    public function addProduction(Production $production): self
    {
        if (!$this->productions->contains($production)) {
            $this->productions[] = $production;
            $production->setRp($this);
        }

        return $this;
    }

    public function removeProduction(Production $production): self
    {
        if ($this->productions->removeElement($production)) {
            // set the owning side to null (unless already changed)
            if ($production->getRp() === $this) {
                $production->setRp(null);
            }
        }

        return $this;
    }

    public function getArchivage(): ?bool
    {
        return $this->archivage;
    }

    public function setArchivage(?bool $archivage): self
    {
        $this->archivage = $archivage;

        return $this;
    }
}
