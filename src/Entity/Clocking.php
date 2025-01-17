<?php

declare(strict_types = 1);

namespace App\Entity;

use App\Repository\ClockingRepository;
use DateTimeInterface;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: ClockingRepository::class)]
class Clocking
{

    #[ORM\ManyToOne(inversedBy: 'clockings')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Project           $clockingProject = null;
    #[ORM\ManyToOne(inversedBy: 'clockings')]
    #[ORM\JoinColumn(nullable: false)]
    private ?User              $clockingUser    = null;
    #[ORM\Column(type: Types::DATE_MUTABLE)]
    private ?DateTimeInterface $date            = null;
    #[Assert\Positive]
    #[Assert\LessThanOrEqual(value: 10)]
    #[ORM\Column(type: Types::INTEGER)]
    private ?int               $duration        = null;
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int               $id              = null;

    #[ORM\OneToMany(targetEntity: ClockingProject::class, mappedBy: 'clocking', orphanRemoval: true)]
    private Collection $clockingsprojects;

    public function __construct()
    {
        $this->clockingsprojects = new ArrayCollection();
    }

    public function getClockingProject() : ?Project
    {
        return $this->clockingProject;
    }

    public function setClockingProject(?Project $clockingProject) : static
    {
        $this->clockingProject = $clockingProject;

        return $this;
    }

    public function getClockingUser() : ?User
    {
        return $this->clockingUser;
    }

    public function setClockingUser(?User $clockingUser) : static
    {
        $this->clockingUser = $clockingUser;

        return $this;
    }

    public function getDate() : ?DateTimeInterface
    {
        return $this->date;
    }

    public function setDate(?DateTimeInterface $date) : void
    {
        $this->date = $date;
    }

    public function getDuration() : ?int
    {
        return $this->duration;
    }

    public function setDuration(?int $duration) : void
    {
        $this->duration = $duration;
    }

    public function getId() : ?int
    {
        return $this->id;
    }

    /**
     * @return Collection<int, ClockingProject>
     */
    public function getClockingsprojects(): Collection
    {
        return $this->clockingsprojects;
    }

    public function addClockingsproject(ClockingProject $clockingsproject): static
    {
        if (!$this->clockingsprojects->contains($clockingsproject)) {
            $this->clockingsprojects->add($clockingsproject);
            $clockingsproject->setClocking($this);
        }

        return $this;
    }

    public function removeClockingsproject(ClockingProject $clockingsproject): static
    {
        if ($this->clockingsprojects->removeElement($clockingsproject)) {
            // set the owning side to null (unless already changed)
            if ($clockingsproject->getClocking() === $this) {
                $clockingsproject->setClocking(null);
            }
        }

        return $this;
    }
}
