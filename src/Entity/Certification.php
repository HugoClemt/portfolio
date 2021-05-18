<?php

namespace App\Entity;

use App\Repository\CertificationRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=CertificationRepository::class)
 */
class Certification
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $libelle;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $url;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $periodeSuivi;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $objectif;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $analyse;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $resultal;

    /**
     * @ORM\ManyToOne(targetEntity=Etudiant::class, inversedBy="certifications")
     */
    private $etudiant;

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

    public function getUrl(): ?string
    {
        return $this->url;
    }

    public function setUrl(?string $url): self
    {
        $this->url = $url;

        return $this;
    }

    public function getPeriodeSuivi(): ?string
    {
        return $this->periodeSuivi;
    }

    public function setPeriodeSuivi(?string $periodeSuivi): self
    {
        $this->periodeSuivi = $periodeSuivi;

        return $this;
    }

    public function getObjectif(): ?string
    {
        return $this->objectif;
    }

    public function setObjectif(?string $objectif): self
    {
        $this->objectif = $objectif;

        return $this;
    }

    public function getAnalyse(): ?string
    {
        return $this->analyse;
    }

    public function setAnalyse(?string $analyse): self
    {
        $this->analyse = $analyse;

        return $this;
    }

    public function getResultal(): ?string
    {
        return $this->resultal;
    }

    public function setResultal(?string $resultal): self
    {
        $this->resultal = $resultal;

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
}
