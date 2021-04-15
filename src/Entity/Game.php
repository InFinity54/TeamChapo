<?php

namespace App\Entity;

use App\Repository\GameRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=GameRepository::class)
 */
class Game
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

    /**
     * @ORM\Column(type="datetime")
     */
    private $startDate;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $duration;

    /**
     * @ORM\Column(type="integer")
     */
    private $queueId;

    /**
     * @ORM\Column(type="integer")
     */
    private $mapId;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $gameVersion;

    /**
     * @ORM\OneToMany(targetEntity=GameParticipant::class, mappedBy="game")
     */
    private $participants;

    /**
     * @ORM\OneToMany(targetEntity=GameTeam::class, mappedBy="game")
     */
    private $teams;

    public function __construct()
    {
        $this->participants = new ArrayCollection();
        $this->teams = new ArrayCollection();
    }

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

    public function getStartDate(): ?\DateTimeInterface
    {
        return $this->startDate;
    }

    public function setStartDate(\DateTimeInterface $startDate): self
    {
        $this->startDate = $startDate;

        return $this;
    }

    public function getDuration(): ?string
    {
        return $this->duration;
    }

    public function setDuration(string $duration): self
    {
        $this->duration = $duration;

        return $this;
    }

    public function getQueueId(): ?int
    {
        return $this->queueId;
    }

    public function setQueueId(int $queueId): self
    {
        $this->queueId = $queueId;

        return $this;
    }

    public function getMapId(): ?int
    {
        return $this->mapId;
    }

    public function setMapId(int $mapId): self
    {
        $this->mapId = $mapId;

        return $this;
    }

    public function getGameVersion(): ?string
    {
        return $this->gameVersion;
    }

    public function setGameVersion(string $gameVersion): self
    {
        $this->gameVersion = $gameVersion;

        return $this;
    }

    /**
     * @return Collection|GameParticipant[]
     */
    public function getParticipants(): Collection
    {
        return $this->participants;
    }

    public function addParticipant(GameParticipant $participant): self
    {
        if (!$this->participants->contains($participant)) {
            $this->participants[] = $participant;
            $participant->setGame($this);
        }

        return $this;
    }

    public function removeParticipant(GameParticipant $participant): self
    {
        if ($this->participants->removeElement($participant)) {
            // set the owning side to null (unless already changed)
            if ($participant->getGame() === $this) {
                $participant->setGame(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|GameTeam[]
     */
    public function getTeams(): Collection
    {
        return $this->teams;
    }

    public function addTeam(GameTeam $team): self
    {
        if (!$this->teams->contains($team)) {
            $this->teams[] = $team;
            $team->setGame($this);
        }

        return $this;
    }

    public function removeTeam(GameTeam $team): self
    {
        if ($this->teams->removeElement($team)) {
            // set the owning side to null (unless already changed)
            if ($team->getGame() === $this) {
                $team->setGame(null);
            }
        }

        return $this;
    }
}
