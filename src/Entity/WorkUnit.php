<?php

namespace App\Entity;

use App\Repository\WorkUnitRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: WorkUnitRepository::class)]
class WorkUnit
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private ?\DateTimeInterface $start = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private ?\DateTimeInterface $end = null;

    #[ORM\ManyToOne(cascade: ['persist', 'remove'], inversedBy: 'workUnit')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Project $project = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getStart(): ?\DateTimeInterface
    {
        return $this->start;
    }

    public function setStart(\DateTimeInterface $start): static
    {
        $this->start = $start;

        return $this;
    }

    public function getEnd(): ?\DateTimeInterface
    {
        return $this->end;
    }

    public function setEnd(\DateTimeInterface $end): static
    {
        $this->end = $end;

        return $this;
    }

    public function getProject(): ?Project
    {
        return $this->project;
    }

    public function setProject(Project $project): static
    {
        $this->project = $project;

        return $this;
    }

    /**
     * Gets the elapsed time between `start date` and `end date` in minutes.
     * @return int
     */
    public function getTimeElapsedInMinutes(): int
    {
        return intval(abs(($this->end->getTimestamp() - $this->start->getTimestamp()) / 60));
    }

    /**
     * This is just a VERY simple validation to stop the user from adding a work unit with time that is negative or zero.
     * In a real application, this would most likely be aligned with FE to throw an exception
     * or at least use Symfony's embedded validation.
     **/
     public function isValid(): bool
    {
        if ($this->end > $this->start ) { return true; }
        return false;
    }
}
