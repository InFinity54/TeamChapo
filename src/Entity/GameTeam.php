<?php

namespace App\Entity;

use App\Repository\GameTeamRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=GameTeamRepository::class)
 */
class GameTeam
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity=Game::class, inversedBy="teams")
     * @ORM\JoinColumn(nullable=false)
     */
    private $game;

    /**
     * @ORM\Column(type="integer")
     */
    private $teamId;

    /**
     * @ORM\ManyToOne(targetEntity=Champion::class)
     * @ORM\JoinColumn(nullable=true)
     */
    private $championBan1;

    /**
     * @ORM\ManyToOne(targetEntity=Champion::class)
     * @ORM\JoinColumn(nullable=true)
     */
    private $championBan2;

    /**
     * @ORM\ManyToOne(targetEntity=Champion::class)
     * @ORM\JoinColumn(nullable=true)
     */
    private $championBan3;

    /**
     * @ORM\ManyToOne(targetEntity=Champion::class)
     * @ORM\JoinColumn(nullable=true)
     */
    private $championBan4;

    /**
     * @ORM\ManyToOne(targetEntity=Champion::class)
     * @ORM\JoinColumn(nullable=true)
     */
    private $championBan5;

    /**
     * @ORM\Column(type="boolean")
     */
    private $firstBaron;

    /**
     * @ORM\Column(type="integer")
     */
    private $totalBaronKills;

    /**
     * @ORM\Column(type="boolean")
     */
    private $firstBlood;

    /**
     * @ORM\Column(type="integer")
     */
    private $totalChampionKills;

    /**
     * @ORM\Column(type="boolean")
     */
    private $firstDragon;

    /**
     * @ORM\Column(type="integer")
     */
    private $totalDragonsKills;

    /**
     * @ORM\Column(type="boolean")
     */
    private $firstInhibitor;

    /**
     * @ORM\Column(type="integer")
     */
    private $totalInhibitorsKills;

    /**
     * @ORM\Column(type="boolean")
     */
    private $firstRiftHerald;

    /**
     * @ORM\Column(type="integer")
     */
    private $totalRiftHeraldKills;

    /**
     * @ORM\Column(type="boolean")
     */
    private $firstTower;

    /**
     * @ORM\Column(type="integer")
     */
    private $totalTowersKills;

    /**
     * @ORM\Column(type="boolean")
     */
    private $win;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getGame(): ?Game
    {
        return $this->game;
    }

    public function setGame(?Game $game): self
    {
        $this->game = $game;

        return $this;
    }

    public function getTeamId(): ?int
    {
        return $this->teamId;
    }

    public function setTeamId(int $teamId): self
    {
        $this->teamId = $teamId;

        return $this;
    }

    public function getChampionBan1(): ?Champion
    {
        return $this->championBan1;
    }

    public function setChampionBan1(?Champion $championBan1): self
    {
        $this->championBan1 = $championBan1;

        return $this;
    }

    public function getChampionBan2(): ?Champion
    {
        return $this->championBan2;
    }

    public function setChampionBan2(?Champion $championBan2): self
    {
        $this->championBan2 = $championBan2;

        return $this;
    }

    public function getChampionBan3(): ?Champion
    {
        return $this->championBan3;
    }

    public function setChampionBan3(?Champion $championBan3): self
    {
        $this->championBan3 = $championBan3;

        return $this;
    }

    public function getChampionBan4(): ?Champion
    {
        return $this->championBan4;
    }

    public function setChampionBan4(?Champion $championBan4): self
    {
        $this->championBan4 = $championBan4;

        return $this;
    }

    public function getChampionBan5(): ?Champion
    {
        return $this->championBan5;
    }

    public function setChampionBan5(?Champion $championBan5): self
    {
        $this->championBan5 = $championBan5;

        return $this;
    }

    public function getFirstBaron(): ?bool
    {
        return $this->firstBaron;
    }

    public function setFirstBaron(bool $firstBaron): self
    {
        $this->firstBaron = $firstBaron;

        return $this;
    }

    public function getTotalBaronKills(): ?int
    {
        return $this->totalBaronKills;
    }

    public function setTotalBaronKills(int $totalBaronKills): self
    {
        $this->totalBaronKills = $totalBaronKills;

        return $this;
    }

    public function getFirstBlood(): ?bool
    {
        return $this->firstBlood;
    }

    public function setFirstBlood(bool $firstBlood): self
    {
        $this->firstBlood = $firstBlood;

        return $this;
    }

    public function getTotalChampionKills(): ?int
    {
        return $this->totalChampionKills;
    }

    public function setTotalChampionKills(int $totalChampionKills): self
    {
        $this->totalChampionKills = $totalChampionKills;

        return $this;
    }

    public function getFirstDragon(): ?bool
    {
        return $this->firstDragon;
    }

    public function setFirstDragon(bool $firstDragon): self
    {
        $this->firstDragon = $firstDragon;

        return $this;
    }

    public function getTotalDragonsKills(): ?int
    {
        return $this->totalDragonsKills;
    }

    public function setTotalDragonsKills(int $totalDragonsKills): self
    {
        $this->totalDragonsKills = $totalDragonsKills;

        return $this;
    }

    public function getFirstInhibitor(): ?bool
    {
        return $this->firstInhibitor;
    }

    public function setFirstInhibitor(bool $firstInhibitor): self
    {
        $this->firstInhibitor = $firstInhibitor;

        return $this;
    }

    public function getTotalInhibitorsKills(): ?int
    {
        return $this->totalInhibitorsKills;
    }

    public function setTotalInhibitorsKills(int $totalInhibitorsKills): self
    {
        $this->totalInhibitorsKills = $totalInhibitorsKills;

        return $this;
    }

    public function getFirstRiftHerald(): ?bool
    {
        return $this->firstRiftHerald;
    }

    public function setFirstRiftHerald(bool $firstRiftHerald): self
    {
        $this->firstRiftHerald = $firstRiftHerald;

        return $this;
    }

    public function getTotalRiftHeraldKills(): ?int
    {
        return $this->totalRiftHeraldKills;
    }

    public function setTotalRiftHeraldKills(int $totalRiftHeraldKills): self
    {
        $this->totalRiftHeraldKills = $totalRiftHeraldKills;

        return $this;
    }

    public function getFirstTower(): ?bool
    {
        return $this->firstTower;
    }

    public function setFirstTower(bool $firstTower): self
    {
        $this->firstTower = $firstTower;

        return $this;
    }

    public function getTotalTowersKills(): ?int
    {
        return $this->totalTowersKills;
    }

    public function setTotalTowersKills(int $totalTowersKills): self
    {
        $this->totalTowersKills = $totalTowersKills;

        return $this;
    }

    public function getWin(): ?bool
    {
        return $this->win;
    }

    public function setWin(bool $win): self
    {
        $this->win = $win;

        return $this;
    }
}
