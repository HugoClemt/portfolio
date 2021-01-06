<?php

namespace App\Entity;

use App\Repository\RPActiviteRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=RPActiviteRepository::class)
 */
class RPActivite
{
	/**
	 * @ORM\Id
	 * @ORM\GeneratedValue
	 * @ORM\Column(type="integer")
	 */
	private $id;

	/**
	 * @ORM\Column(type="text", nullable=true)
	 */
	private $commentaire;

	/**
	 * @ORM\ManyToOne(targetEntity=Niveau::class, inversedBy="activites")
	 */
	private $niveau;

	/**
	 * @ORM\ManyToOne(targetEntity=Activite::class, inversedBy="RPs")
	 * @ORM\JoinColumn(nullable=false)
	 */
	private $activite;

	/**
	 * @ORM\ManyToOne(targetEntity=RP::class, inversedBy="activites")
	 * @ORM\JoinColumn(nullable=false)
	 */
	private $rp;

	public function getId(): ?int
	{
		return $this->id;
	}

	public function getCommentaire(): ?string
	{
		return $this->commentaire;
	}

	public function setCommentaire(?string $commentaire): self
	{
		$this->commentaire = $commentaire;

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

	public function getActivite(): ?Activite
	{
		return $this->activite;
	}

	public function setActivite(?Activite $activite): self
	{
		$this->activite = $activite;

		return $this;
	}

	public function getRp(): ?RP
	{
		return $this->rp;
	}

	public function setRp(?RP $rp): self
	{
		$this->rp = $rp;

		return $this;
	}
}
