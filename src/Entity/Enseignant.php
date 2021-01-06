<?php

namespace App\Entity;

use App\Repository\EnseignantRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=EnseignantRepository::class)
 */
class Enseignant
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
    private $nom;

    /**
     * @ORM\Column(type="string", length=50, nullable=true)
     */
    private $prenom;

    /**
     * @ORM\Column(type="string", length=60, nullable=true)
     */
    private $mail;

    /**
     * @ORM\Column(type="string", length=20, nullable=true)
     */
    private $niveau;

    /**
     * @ORM\Column(type="string", length=60, nullable=true)
     */
    private $statut;

    /**
     * @ORM\OneToMany(targetEntity=Commentaire::class, mappedBy="enseignant")
     */
    private $commentaires;

    /**
     * @ORM\OneToMany(targetEntity=RP::class, mappedBy="enseignant")
     * @ORM\OrderBy({"etudiant" = "ASC"})
     */
    private $RPs;

    /**
     * @ORM\ManyToOne(targetEntity=Matiere::class, inversedBy="enseignants")
     */
    private $matiere;

    /**
     * @ORM\OneToMany(targetEntity=Stage::class, mappedBy="enseignant")
     */
    private $stages;

    public function __construct()
    {
        $this->commentaires = new ArrayCollection();
        $this->RPs = new ArrayCollection();
        $this->stages = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNom(): ?string
    {
        return $this->nom;
    }

    public function setNom(?string $nom): self
    {
        $this->nom = $nom;

        return $this;
    }

    public function getPrenom(): ?string
    {
        return $this->prenom;
    }

    public function setPrenom(?string $prenom): self
    {
        $this->prenom = $prenom;

        return $this;
    }

    public function getMail(): ?string
    {
        return $this->mail;
    }

    public function setMail(?string $mail): self
    {
        $this->mail = $mail;

        return $this;
    }

    public function getNiveau(): ?string
    {
        return $this->niveau;
    }

    public function setNiveau(?string $niveau): self
    {
        $this->niveau = $niveau;

        return $this;
    }

    public function getStatut(): ?string
    {
        return $this->statut;
    }

    public function setStatut(?string $statut): self
    {
        $this->statut = $statut;

        return $this;
    }

    /**
     * @return Collection|Commentaire[]
     */
    public function getCommentaires(): Collection
    {
        return $this->commentaires;
    }

    public function addCommentaire(Commentaire $commentaire): self
    {
        if (!$this->commentaires->contains($commentaire)) {
            $this->commentaires[] = $commentaire;
            $commentaire->setEnseignant($this);
        }

        return $this;
    }

    public function removeCommentaire(Commentaire $commentaire): self
    {
        if ($this->commentaires->removeElement($commentaire)) {
            // set the owning side to null (unless already changed)
            if ($commentaire->getEnseignant() === $this) {
                $commentaire->setEnseignant(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|RP[]
     */
    public function getRPs(): Collection
    {
        return $this->RPs;
    }

    public function addRP(RP $rP): self
    {
        if (!$this->RPs->contains($rP)) {
            $this->RPs[] = $rP;
            $rP->setEnseignant($this);
        }

        return $this;
    }

    public function removeRP(RP $rP): self
    {
        if ($this->RPs->removeElement($rP)) {
            // set the owning side to null (unless already changed)
            if ($rP->getEnseignant() === $this) {
                $rP->setEnseignant(null);
            }
        }

        return $this;
    }

    public function getMatiere(): ?Matiere
    {
        return $this->matiere;
    }

    public function setMatiere(?Matiere $matiere): self
    {
        $this->matiere = $matiere;

        return $this;
    }

    /**
     * @return Collection|Stage[]
     */
    public function getStages(): Collection
    {
        return $this->stages;
    }

    public function addStage(Stage $stage): self
    {
        if (!$this->stages->contains($stage)) {
            $this->stages[] = $stage;
            $stage->setEnseignant($this);
        }

        return $this;
    }

    public function removeStage(Stage $stage): self
    {
        if ($this->stages->removeElement($stage)) {
            // set the owning side to null (unless already changed)
            if ($stage->getEnseignant() === $this) {
                $stage->setEnseignant(null);
            }
        }

        return $this;

    }




    }    
