<?php

namespace App\Entity;

use App\Repository\PointageRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=PointageRepository::class)
 */
class Pointage
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="date", nullable=true)
     */
    private $datepoint;

    /**
     * @ORM\Column(type="time", nullable=true)
     */
    private $heurepoint;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $ip;

    /**
     * @ORM\ManyToOne(targetEntity=Stage::class, inversedBy="pointages")
     */
    private $stage;


    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDatepoint(): ?\DateTimeInterface
    {
        return $this->datepoint;
    }

    public function setDatepoint(?\DateTimeInterface $datepoint): self
    {
        $this->datepoint = $datepoint;

        return $this;
    }

    public function getHeurepoint(): ?\DateTimeInterface
    {
        return $this->heurepoint;
    }

    public function setHeurepoint(?\DateTimeInterface $heurepoint): self
    {
        $this->heurepoint = $heurepoint;

        return $this;
    }

    public function getIp(): ?string
    {
        return $this->ip;
    }

    public function setIp(?string $ip): self
    {
        $this->ip = $ip;

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
}
