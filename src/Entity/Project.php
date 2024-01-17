<?php

namespace App\Entity;

use App\Repository\ProjectRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ProjectRepository::class)]
class Project
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $name = null;

    #[ORM\OneToOne(mappedBy: 'project', cascade: ['persist', 'remove'])]
    private ?WorkUnit $workUnit = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): static
    {
        $this->name = $name;

        return $this;
    }

    public function getWorkUnit(): ?WorkUnit
    {
        return $this->workUnit;
    }

    public function setWorkUnit(WorkUnit $workUnit): static
    {
        // set the owning side of the relation if necessary
        if ($workUnit->getProject() !== $this) {
            $workUnit->setProject($this);
        }

        $this->workUnit = $workUnit;

        return $this;
    }
}
