<?php

namespace App\Entity;

use App\Repository\GameSkipRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=GameSkipRepository::class)
 */
class GameSkip
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $riotId;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getRiotId(): ?string
    {
        return $this->riotId;
    }

    public function setRiotId(string $riotId): self
    {
        $this->riotId = $riotId;

        return $this;
    }
}
