<?php

namespace App\Entity;

use App\Repository\VideosRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=VideosRepository::class)
 */
class Videos
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity=Tricks::class, inversedBy="videos")
     * @ORM\JoinColumn(nullable=false)
     */
    private $trick_id;

    /**
     * @ORM\Column(type="text")
     */
    private $embed;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTrickId(): ?Tricks
    {
        return $this->trick_id;
    }

    public function setTrickId(?Tricks $trick_id): self
    {
        $this->trick_id = $trick_id;

        return $this;
    }

    public function getEmbed(): ?string
    {
        return $this->embed;
    }

    public function setEmbed(string $embed): self
    {
        $this->embed = $embed;

        return $this;
    }
}
