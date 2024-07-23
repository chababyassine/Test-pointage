<?php

namespace App\Entity;

use App\Entity\Clocking;
use App\Entity\Project;
use App\Repository\ClockingProjectRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ClockingProjectRepository::class)]
class ClockingProject
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne]
    #[ORM\JoinColumn(nullable: false)]
    private ?Project $project = null;

    #[ORM\Column]
    private ?int $duree = null;

    #[ORM\ManyToOne(inversedBy: 'clockingsprojects')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Clocking $clocking = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getProject(): ?Project
    {
        return $this->project;
    }
    

    public function setProject(?Project $project): static
    {
        $this->project = $project;

        return $this;
    }

    public function getDuree(): ?int
    {
        return $this->duree;
    }

    public function setDuree(int $duree): static
    {
        $this->duree = $duree;

        return $this;
    }

    public function getClocking(): ?Clocking
    {
        return $this->clocking;
    }

    public function setClocking(?Clocking $clocking): static
    {
        $this->clocking = $clocking;

        return $this;
    }
}
