<?php

namespace App\Entity;

use App\Repository\TricksRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=TricksRepository::class)
 */
class Tricks
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255, unique=true)
     */
    private $name;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $discription;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $grouping;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getDiscription(): ?string
    {
        return $this->discription;
    }

    public function setDiscription(?string $discription): self
    {
        $this->discription = $discription;

        return $this;
    }

    public function getGrouping(): ?string
    {
        return $this->grouping;
    }

    public function setGrouping(?string $grouping): self
    {
        $this->grouping = $grouping;

        return $this;
    }
}
