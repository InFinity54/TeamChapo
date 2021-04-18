<?php

namespace App\Entity;

use App\Repository\GameParticipantRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=GameParticipantRepository::class)
 */
class GameParticipant
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity=Game::class, inversedBy="participants")
     * @ORM\JoinColumn(nullable=false)
     */
    private $game;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $puuid;

    /**
     * @ORM\Column(type="integer")
     */
    private $kills;

    /**
     * @ORM\Column(type="integer")
     */
    private $deaths;

    /**
     * @ORM\Column(type="integer")
     */
    private $assists;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $item1;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $item2;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $item3;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $item4;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $item5;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $item6;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $ward;

    /**
     * @ORM\ManyToOne(targetEntity=Champion::class)
     * @ORM\JoinColumn(nullable=false)
     */
    private $champion;

    /**
     * @ORM\Column(type="integer")
     */
    private $championLevel;

    /**
     * @ORM\Column(type="integer")
     */
    private $damageDealtToBuildings;

    /**
     * @ORM\Column(type="integer")
     */
    private $damageDealtToObjectives;

    /**
     * @ORM\Column(type="integer")
     */
    private $damageDealtToTurrets;

    /**
     * @ORM\Column(type="integer")
     */
    private $damageSelfMitigated;

    /**
     * @ORM\Column(type="integer")
     */
    private $baronKills;

    /**
     * @ORM\Column(type="integer")
     */
    private $doubleKills;

    /**
     * @ORM\Column(type="integer")
     */
    private $dragonKills;

    /**
     * @ORM\Column(type="boolean")
     */
    private $firstBloodAssist;

    /**
     * @ORM\Column(type="boolean")
     */
    private $firstBloodKill;

    /**
     * @ORM\Column(type="boolean")
     */
    private $firstTowerAssist;

    /**
     * @ORM\Column(type="boolean")
     */
    private $firstTowerKill;

    /**
     * @ORM\Column(type="boolean")
     */
    private $gameEndedInEarlySurrender;

    /**
     * @ORM\Column(type="boolean")
     */
    private $gameEndedInSurrender;

    /**
     * @ORM\Column(type="integer")
     */
    private $goldEarned;

    /**
     * @ORM\Column(type="integer")
     */
    private $goldSpent;

    /**
     * @ORM\Column(type="integer")
     */
    private $inhibitorKills;

    /**
     * @ORM\Column(type="integer")
     */
    private $inhibitorsLost;

    /**
     * @ORM\Column(type="integer")
     */
    private $killingSprees;

    /**
     * @ORM\ManyToOne(targetEntity=Lane::class)
     */
    private $lane;

    /**
     * @ORM\Column(type="integer")
     */
    private $largestCriticalStrike;

    /**
     * @ORM\Column(type="integer")
     */
    private $largestKillingSpree;

    /**
     * @ORM\Column(type="integer")
     */
    private $largestMultiKill;

    /**
     * @ORM\Column(type="integer")
     */
    private $longestTimeSpentLiving;

    /**
     * @ORM\Column(type="integer")
     */
    private $magicDamageDealt;

    /**
     * @ORM\Column(type="integer")
     */
    private $magicDamageDealtToChampions;

    /**
     * @ORM\Column(type="integer")
     */
    private $magicDamageTaken;

    /**
     * @ORM\Column(type="integer")
     */
    private $neutralMinionsKilled;

    /**
     * @ORM\Column(type="integer")
     */
    private $nexusKills;

    /**
     * @ORM\Column(type="integer")
     */
    private $objectivesStolen;

    /**
     * @ORM\Column(type="integer")
     */
    private $objectivesStolenAssists;

    /**
     * @ORM\Column(type="integer")
     */
    private $pentaKills;

    /**
     * @ORM\Column(type="integer")
     */
    private $perksStatsDefense;

    /**
     * @ORM\Column(type="integer")
     */
    private $perksStatsFlex;

    /**
     * @ORM\Column(type="integer")
     */
    private $perksStatsOffense;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $perksPrimarySelection1;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $perksPrimarySelection2;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $perksPrimarySelection3;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $perksPrimarySelection4;

    /**
     * @ORM\Column(type="integer")
     */
    private $perksPrimaryStyle;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $perksSecondarySelection1;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $perksSecondarySelection2;

    /**
     * @ORM\Column(type="integer")
     */
    private $perksSecondaryStyle;

    /**
     * @ORM\Column(type="integer")
     */
    private $physicalDamageDealt;

    /**
     * @ORM\Column(type="integer")
     */
    private $physicalDamageDealtToChampions;

    /**
     * @ORM\Column(type="integer")
     */
    private $physicalDamageTaken;

    /**
     * @ORM\Column(type="integer")
     */
    private $quadraKills;

    /**
     * @ORM\Column(type="integer")
     */
    private $spellACasts;

    /**
     * @ORM\Column(type="integer")
     */
    private $spellZCasts;

    /**
     * @ORM\Column(type="integer")
     */
    private $spellECasts;

    /**
     * @ORM\Column(type="integer")
     */
    private $spellRCasts;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $summonerName;

    /**
     * @ORM\Column(type="integer")
     */
    private $summonerSpell1Id;

    /**
     * @ORM\Column(type="integer")
     */
    private $summonerSpell1Casts;

    /**
     * @ORM\Column(type="integer")
     */
    private $summonerSpell2Id;

    /**
     * @ORM\Column(type="integer")
     */
    private $summonerSpell2Casts;

    /**
     * @ORM\Column(type="integer")
     */
    private $teamId;

    /**
     * @ORM\Column(type="integer")
     */
    private $totalDamageDealt;

    /**
     * @ORM\Column(type="integer")
     */
    private $totalDamageDealtToChampions;

    /**
     * @ORM\Column(type="integer")
     */
    private $totalDamageShieldedOnTeammates;

    /**
     * @ORM\Column(type="integer")
     */
    private $totalDamageTaken;

    /**
     * @ORM\Column(type="integer")
     */
    private $totalHeal;

    /**
     * @ORM\Column(type="integer")
     */
    private $totalHealsOnTeammates;

    /**
     * @ORM\Column(type="integer")
     */
    private $totalMinionsKilled;

    /**
     * @ORM\Column(type="integer")
     */
    private $totalTimeCCDealt;

    /**
     * @ORM\Column(type="integer")
     */
    private $totalTimeSpentDead;

    /**
     * @ORM\Column(type="integer")
     */
    private $totalUnitsHealed;

    /**
     * @ORM\Column(type="integer")
     */
    private $tripleKills;

    /**
     * @ORM\Column(type="integer")
     */
    private $trueDamageDealt;

    /**
     * @ORM\Column(type="integer")
     */
    private $trueDamageDealtToChampions;

    /**
     * @ORM\Column(type="integer")
     */
    private $trueDamageTaken;

    /**
     * @ORM\Column(type="integer")
     */
    private $turretKills;

    /**
     * @ORM\Column(type="integer")
     */
    private $unrealKills;

    /**
     * @ORM\Column(type="integer")
     */
    private $visionScore;

    /**
     * @ORM\Column(type="integer")
     */
    private $visionWardsBoughtInGame;

    /**
     * @ORM\Column(type="integer")
     */
    private $wardsKilled;

    /**
     * @ORM\Column(type="integer")
     */
    private $wardsPlaced;

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

    public function getPuuid(): ?string
    {
        return $this->puuid;
    }

    public function setPuuid(string $puuid): self
    {
        $this->puuid = $puuid;

        return $this;
    }

    public function getKills(): ?int
    {
        return $this->kills;
    }

    public function setKills(int $kills): self
    {
        $this->kills = $kills;

        return $this;
    }

    public function getDeaths(): ?int
    {
        return $this->deaths;
    }

    public function setDeaths(int $deaths): self
    {
        $this->deaths = $deaths;

        return $this;
    }

    public function getAssists(): ?int
    {
        return $this->assists;
    }

    public function setAssists(int $assists): self
    {
        $this->assists = $assists;

        return $this;
    }

    public function getItem1(): ?int
    {
        return $this->item1;
    }

    public function setItem1(?int $item1): self
    {
        $this->item1 = $item1;

        return $this;
    }

    public function getItem2(): ?int
    {
        return $this->item2;
    }

    public function setItem2(?int $item2): self
    {
        $this->item2 = $item2;

        return $this;
    }

    public function getItem3(): ?int
    {
        return $this->item3;
    }

    public function setItem3(?int $item3): self
    {
        $this->item3 = $item3;

        return $this;
    }

    public function getItem4(): ?int
    {
        return $this->item4;
    }

    public function setItem4(?int $item4): self
    {
        $this->item4 = $item4;

        return $this;
    }

    public function getItem5(): ?int
    {
        return $this->item5;
    }

    public function setItem5(?int $item5): self
    {
        $this->item5 = $item5;

        return $this;
    }

    public function getItem6(): ?int
    {
        return $this->item6;
    }

    public function setItem6(?int $item6): self
    {
        $this->item6 = $item6;

        return $this;
    }

    public function getWard(): ?int
    {
        return $this->ward;
    }

    public function setWard(?int $ward): self
    {
        $this->ward = $ward;

        return $this;
    }

    public function getChampion(): ?Champion
    {
        return $this->champion;
    }

    public function setChampion(?Champion $champion): self
    {
        $this->champion = $champion;

        return $this;
    }

    public function getChampionLevel(): ?int
    {
        return $this->championLevel;
    }

    public function setChampionLevel(int $championLevel): self
    {
        $this->championLevel = $championLevel;

        return $this;
    }

    public function getDamageDealtToBuildings(): ?int
    {
        return $this->damageDealtToBuildings;
    }

    public function setDamageDealtToBuildings(int $damageDealtToBuildings): self
    {
        $this->damageDealtToBuildings = $damageDealtToBuildings;

        return $this;
    }

    public function getDamageDealtToObjectives(): ?int
    {
        return $this->damageDealtToObjectives;
    }

    public function setDamageDealtToObjectives(int $damageDealtToObjectives): self
    {
        $this->damageDealtToObjectives = $damageDealtToObjectives;

        return $this;
    }

    public function getDamageDealtToTurrets(): ?int
    {
        return $this->damageDealtToTurrets;
    }

    public function setDamageDealtToTurrets(int $damageDealtToTurrets): self
    {
        $this->damageDealtToTurrets = $damageDealtToTurrets;

        return $this;
    }

    public function getDamageSelfMitigated(): ?int
    {
        return $this->damageSelfMitigated;
    }

    public function setDamageSelfMitigated(int $damageSelfMitigated): self
    {
        $this->damageSelfMitigated = $damageSelfMitigated;

        return $this;
    }

    public function getBaronKills(): ?int
    {
        return $this->baronKills;
    }

    public function setBaronKills(int $baronKills): self
    {
        $this->baronKills = $baronKills;

        return $this;
    }

    public function getDoubleKills(): ?int
    {
        return $this->doubleKills;
    }

    public function setDoubleKills(int $doubleKills): self
    {
        $this->doubleKills = $doubleKills;

        return $this;
    }

    public function getDragonKills(): ?int
    {
        return $this->dragonKills;
    }

    public function setDragonKills(int $dragonKills): self
    {
        $this->dragonKills = $dragonKills;

        return $this;
    }

    public function getFirstBloodAssist(): ?bool
    {
        return $this->firstBloodAssist;
    }

    public function setFirstBloodAssist(bool $firstBloodAssist): self
    {
        $this->firstBloodAssist = $firstBloodAssist;

        return $this;
    }

    public function getFirstBloodKill(): ?bool
    {
        return $this->firstBloodKill;
    }

    public function setFirstBloodKill(bool $firstBloodKill): self
    {
        $this->firstBloodKill = $firstBloodKill;

        return $this;
    }

    public function getFirstTowerAssist(): ?bool
    {
        return $this->firstTowerAssist;
    }

    public function setFirstTowerAssist(bool $firstTowerAssist): self
    {
        $this->firstTowerAssist = $firstTowerAssist;

        return $this;
    }

    public function getFirstTowerKill(): ?bool
    {
        return $this->firstTowerKill;
    }

    public function setFirstTowerKill(bool $firstTowerKill): self
    {
        $this->firstTowerKill = $firstTowerKill;

        return $this;
    }

    public function getGameEndedInEarlySurrender(): ?bool
    {
        return $this->gameEndedInEarlySurrender;
    }

    public function setGameEndedInEarlySurrender(bool $gameEndedInEarlySurrender): self
    {
        $this->gameEndedInEarlySurrender = $gameEndedInEarlySurrender;

        return $this;
    }

    public function getGameEndedInSurrender(): ?bool
    {
        return $this->gameEndedInSurrender;
    }

    public function setGameEndedInSurrender(bool $gameEndedInSurrender): self
    {
        $this->gameEndedInSurrender = $gameEndedInSurrender;

        return $this;
    }

    public function getGoldEarned(): ?int
    {
        return $this->goldEarned;
    }

    public function setGoldEarned(int $goldEarned): self
    {
        $this->goldEarned = $goldEarned;

        return $this;
    }

    public function getGoldSpent(): ?int
    {
        return $this->goldSpent;
    }

    public function setGoldSpent(int $goldSpent): self
    {
        $this->goldSpent = $goldSpent;

        return $this;
    }

    public function getInhibitorKills(): ?int
    {
        return $this->inhibitorKills;
    }

    public function setInhibitorKills(int $inhibitorKills): self
    {
        $this->inhibitorKills = $inhibitorKills;

        return $this;
    }

    public function getInhibitorsLost(): ?int
    {
        return $this->inhibitorsLost;
    }

    public function setInhibitorsLost(int $inhibitorsLost): self
    {
        $this->inhibitorsLost = $inhibitorsLost;

        return $this;
    }

    public function getKillingSprees(): ?int
    {
        return $this->killingSprees;
    }

    public function setKillingSprees(int $killingSprees): self
    {
        $this->killingSprees = $killingSprees;

        return $this;
    }

    public function getLane(): ?Lane
    {
        return $this->lane;
    }

    public function setLane(?Lane $lane): self
    {
        $this->lane = $lane;

        return $this;
    }

    public function getLargestCriticalStrike(): ?int
    {
        return $this->largestCriticalStrike;
    }

    public function setLargestCriticalStrike(int $largestCriticalStrike): self
    {
        $this->largestCriticalStrike = $largestCriticalStrike;

        return $this;
    }

    public function getLargestKillingSpree(): ?int
    {
        return $this->largestKillingSpree;
    }

    public function setLargestKillingSpree(int $largestKillingSpree): self
    {
        $this->largestKillingSpree = $largestKillingSpree;

        return $this;
    }

    public function getLargestMultiKill(): ?int
    {
        return $this->largestMultiKill;
    }

    public function setLargestMultiKill(int $largestMultiKill): self
    {
        $this->largestMultiKill = $largestMultiKill;

        return $this;
    }

    public function getLongestTimeSpentLiving(): ?int
    {
        return $this->longestTimeSpentLiving;
    }

    public function setLongestTimeSpentLiving(int $longestTimeSpentLiving): self
    {
        $this->longestTimeSpentLiving = $longestTimeSpentLiving;

        return $this;
    }

    public function getMagicDamageDealt(): ?int
    {
        return $this->magicDamageDealt;
    }

    public function setMagicDamageDealt(int $magicDamageDealt): self
    {
        $this->magicDamageDealt = $magicDamageDealt;

        return $this;
    }

    public function getMagicDamageDealtToChampions(): ?int
    {
        return $this->magicDamageDealtToChampions;
    }

    public function setMagicDamageDealtToChampions(int $magicDamageDealtToChampions): self
    {
        $this->magicDamageDealtToChampions = $magicDamageDealtToChampions;

        return $this;
    }

    public function getMagicDamageTaken(): ?int
    {
        return $this->magicDamageTaken;
    }

    public function setMagicDamageTaken(int $magicDamageTaken): self
    {
        $this->magicDamageTaken = $magicDamageTaken;

        return $this;
    }

    public function getNeutralMinionsKilled(): ?int
    {
        return $this->neutralMinionsKilled;
    }

    public function setNeutralMinionsKilled(int $neutralMinionsKilled): self
    {
        $this->neutralMinionsKilled = $neutralMinionsKilled;

        return $this;
    }

    public function getNexusKills(): ?int
    {
        return $this->nexusKills;
    }

    public function setNexusKills(int $nexusKills): self
    {
        $this->nexusKills = $nexusKills;

        return $this;
    }

    public function getObjectivesStolen(): ?int
    {
        return $this->objectivesStolen;
    }

    public function setObjectivesStolen(int $objectivesStolen): self
    {
        $this->objectivesStolen = $objectivesStolen;

        return $this;
    }

    public function getObjectivesStolenAssists(): ?int
    {
        return $this->objectivesStolenAssists;
    }

    public function setObjectivesStolenAssists(int $objectivesStolenAssists): self
    {
        $this->objectivesStolenAssists = $objectivesStolenAssists;

        return $this;
    }

    public function getPentaKills(): ?int
    {
        return $this->pentaKills;
    }

    public function setPentaKills(int $pentaKills): self
    {
        $this->pentaKills = $pentaKills;

        return $this;
    }

    public function getPerksStatsDefense(): ?int
    {
        return $this->perksStatsDefense;
    }

    public function setPerksStatsDefense(int $perksStatsDefense): self
    {
        $this->perksStatsDefense = $perksStatsDefense;

        return $this;
    }

    public function getPerksStatsFlex(): ?int
    {
        return $this->perksStatsFlex;
    }

    public function setPerksStatsFlex(int $perksStatsFlex): self
    {
        $this->perksStatsFlex = $perksStatsFlex;

        return $this;
    }

    public function getPerksStatsOffense(): ?int
    {
        return $this->perksStatsOffense;
    }

    public function setPerksStatsOffense(int $perksStatsOffense): self
    {
        $this->perksStatsOffense = $perksStatsOffense;

        return $this;
    }

    public function getPerksPrimarySelection1(): ?string
    {
        return $this->perksPrimarySelection1;
    }

    public function setPerksPrimarySelection1(string $perksPrimarySelection1): self
    {
        $this->perksPrimarySelection1 = $perksPrimarySelection1;

        return $this;
    }

    public function getPerksPrimarySelection2(): ?string
    {
        return $this->perksPrimarySelection2;
    }

    public function setPerksPrimarySelection2(string $perksPrimarySelection2): self
    {
        $this->perksPrimarySelection2 = $perksPrimarySelection2;

        return $this;
    }

    public function getPerksPrimarySelection3(): ?string
    {
        return $this->perksPrimarySelection3;
    }

    public function setPerksPrimarySelection3(string $perksPrimarySelection3): self
    {
        $this->perksPrimarySelection3 = $perksPrimarySelection3;

        return $this;
    }

    public function getPerksPrimarySelection4(): ?string
    {
        return $this->perksPrimarySelection4;
    }

    public function setPerksPrimarySelection4(string $perksPrimarySelection4): self
    {
        $this->perksPrimarySelection4 = $perksPrimarySelection4;

        return $this;
    }

    public function getPerksPrimaryStyle(): ?int
    {
        return $this->perksPrimaryStyle;
    }

    public function setPerksPrimaryStyle(int $perksPrimaryStyle): self
    {
        $this->perksPrimaryStyle = $perksPrimaryStyle;

        return $this;
    }

    public function getPerksSecondarySelection1(): ?string
    {
        return $this->perksSecondarySelection1;
    }

    public function setPerksSecondarySelection1(string $perksSecondarySelection1): self
    {
        $this->perksSecondarySelection1 = $perksSecondarySelection1;

        return $this;
    }

    public function getPerksSecondarySelection2(): ?string
    {
        return $this->perksSecondarySelection2;
    }

    public function setPerksSecondarySelection2(string $perksSecondarySelection2): self
    {
        $this->perksSecondarySelection2 = $perksSecondarySelection2;

        return $this;
    }

    public function getPerksSecondaryStyle(): ?int
    {
        return $this->perksSecondaryStyle;
    }

    public function setPerksSecondaryStyle(int $perksSecondaryStyle): self
    {
        $this->perksSecondaryStyle = $perksSecondaryStyle;

        return $this;
    }

    public function getPhysicalDamageDealt(): ?int
    {
        return $this->physicalDamageDealt;
    }

    public function setPhysicalDamageDealt(int $physicalDamageDealt): self
    {
        $this->physicalDamageDealt = $physicalDamageDealt;

        return $this;
    }

    public function getPhysicalDamageDealtToChampions(): ?int
    {
        return $this->physicalDamageDealtToChampions;
    }

    public function setPhysicalDamageDealtToChampions(int $physicalDamageDealtToChampions): self
    {
        $this->physicalDamageDealtToChampions = $physicalDamageDealtToChampions;

        return $this;
    }

    public function getPhysicalDamageTaken(): ?int
    {
        return $this->physicalDamageTaken;
    }

    public function setPhysicalDamageTaken(int $physicalDamageTaken): self
    {
        $this->physicalDamageTaken = $physicalDamageTaken;

        return $this;
    }

    public function getQuadraKills(): ?int
    {
        return $this->quadraKills;
    }

    public function setQuadraKills(int $quadraKills): self
    {
        $this->quadraKills = $quadraKills;

        return $this;
    }

    public function getSpellACasts(): ?int
    {
        return $this->spellACasts;
    }

    public function setSpellACasts(int $spellACasts): self
    {
        $this->spellACasts = $spellACasts;

        return $this;
    }

    public function getSpellZCasts(): ?int
    {
        return $this->spellZCasts;
    }

    public function setSpellZCasts(int $spellZCasts): self
    {
        $this->spellZCasts = $spellZCasts;

        return $this;
    }

    public function getSpellECasts(): ?int
    {
        return $this->spellECasts;
    }

    public function setSpellECasts(int $spellECasts): self
    {
        $this->spellECasts = $spellECasts;

        return $this;
    }

    public function getSpellRCasts(): ?int
    {
        return $this->spellRCasts;
    }

    public function setSpellRCasts(int $spellRCasts): self
    {
        $this->spellRCasts = $spellRCasts;

        return $this;
    }

    public function getSummonerName(): ?string
    {
        return $this->summonerName;
    }

    public function setSummonerName(string $summonerName): self
    {
        $this->summonerName = $summonerName;

        return $this;
    }

    public function getSummonerSpell1Id(): ?int
    {
        return $this->summonerSpell1Id;
    }

    public function setSummonerSpell1Id(int $summonerSpell1Id): self
    {
        $this->summonerSpell1Id = $summonerSpell1Id;

        return $this;
    }

    public function getSummonerSpell1Casts(): ?int
    {
        return $this->summonerSpell1Casts;
    }

    public function setSummonerSpell1Casts(int $summonerSpell1Casts): self
    {
        $this->summonerSpell1Casts = $summonerSpell1Casts;

        return $this;
    }

    public function getSummonerSpell2Id(): ?int
    {
        return $this->summonerSpell2Id;
    }

    public function setSummonerSpell2Id(int $summonerSpell2Id): self
    {
        $this->summonerSpell2Id = $summonerSpell2Id;

        return $this;
    }

    public function getSummonerSpell2Casts(): ?int
    {
        return $this->summonerSpell2Casts;
    }

    public function setSummonerSpell2Casts(int $summonerSpell2Casts): self
    {
        $this->summonerSpell2Casts = $summonerSpell2Casts;

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

    public function getTotalDamageDealt(): ?int
    {
        return $this->totalDamageDealt;
    }

    public function setTotalDamageDealt(int $totalDamageDealt): self
    {
        $this->totalDamageDealt = $totalDamageDealt;

        return $this;
    }

    public function getTotalDamageDealtToChampions(): ?int
    {
        return $this->totalDamageDealtToChampions;
    }

    public function setTotalDamageDealtToChampions(int $totalDamageDealtToChampions): self
    {
        $this->totalDamageDealtToChampions = $totalDamageDealtToChampions;

        return $this;
    }

    public function getTotalDamageShieldedOnTeammates(): ?int
    {
        return $this->totalDamageShieldedOnTeammates;
    }

    public function setTotalDamageShieldedOnTeammates(int $totalDamageShieldedOnTeammates): self
    {
        $this->totalDamageShieldedOnTeammates = $totalDamageShieldedOnTeammates;

        return $this;
    }

    public function getTotalDamageTaken(): ?int
    {
        return $this->totalDamageTaken;
    }

    public function setTotalDamageTaken(int $totalDamageTaken): self
    {
        $this->totalDamageTaken = $totalDamageTaken;

        return $this;
    }

    public function getTotalHeal(): ?int
    {
        return $this->totalHeal;
    }

    public function setTotalHeal(int $totalHeal): self
    {
        $this->totalHeal = $totalHeal;

        return $this;
    }

    public function getTotalHealsOnTeammates(): ?int
    {
        return $this->totalHealsOnTeammates;
    }

    public function setTotalHealsOnTeammates(int $totalHealsOnTeammates): self
    {
        $this->totalHealsOnTeammates = $totalHealsOnTeammates;

        return $this;
    }

    public function getTotalMinionsKilled(): ?int
    {
        return $this->totalMinionsKilled;
    }

    public function setTotalMinionsKilled(int $totalMinionsKilled): self
    {
        $this->totalMinionsKilled = $totalMinionsKilled;

        return $this;
    }

    public function getTotalTimeCCDealt(): ?int
    {
        return $this->totalTimeCCDealt;
    }

    public function setTotalTimeCCDealt(int $totalTimeCCDealt): self
    {
        $this->totalTimeCCDealt = $totalTimeCCDealt;

        return $this;
    }

    public function getTotalTimeSpentDead(): ?int
    {
        return $this->totalTimeSpentDead;
    }

    public function setTotalTimeSpentDead(int $totalTimeSpentDead): self
    {
        $this->totalTimeSpentDead = $totalTimeSpentDead;

        return $this;
    }

    public function getTotalUnitsHealed(): ?int
    {
        return $this->totalUnitsHealed;
    }

    public function setTotalUnitsHealed(int $totalUnitsHealed): self
    {
        $this->totalUnitsHealed = $totalUnitsHealed;

        return $this;
    }

    public function getTripleKills(): ?int
    {
        return $this->tripleKills;
    }

    public function setTripleKills(int $tripleKills): self
    {
        $this->tripleKills = $tripleKills;

        return $this;
    }

    public function getTrueDamageDealt(): ?int
    {
        return $this->trueDamageDealt;
    }

    public function setTrueDamageDealt(int $trueDamageDealt): self
    {
        $this->trueDamageDealt = $trueDamageDealt;

        return $this;
    }

    public function getTrueDamageDealtToChampions(): ?int
    {
        return $this->trueDamageDealtToChampions;
    }

    public function setTrueDamageDealtToChampions(int $trueDamageDealtToChampions): self
    {
        $this->trueDamageDealtToChampions = $trueDamageDealtToChampions;

        return $this;
    }

    public function getTrueDamageTaken(): ?int
    {
        return $this->trueDamageTaken;
    }

    public function setTrueDamageTaken(int $trueDamageTaken): self
    {
        $this->trueDamageTaken = $trueDamageTaken;

        return $this;
    }

    public function getTurretKills(): ?int
    {
        return $this->turretKills;
    }

    public function setTurretKills(int $turretKills): self
    {
        $this->turretKills = $turretKills;

        return $this;
    }

    public function getUnrealKills(): ?int
    {
        return $this->unrealKills;
    }

    public function setUnrealKills(int $unrealKills): self
    {
        $this->unrealKills = $unrealKills;

        return $this;
    }

    public function getVisionScore(): ?int
    {
        return $this->visionScore;
    }

    public function setVisionScore(int $visionScore): self
    {
        $this->visionScore = $visionScore;

        return $this;
    }

    public function getVisionWardsBoughtInGame(): ?int
    {
        return $this->visionWardsBoughtInGame;
    }

    public function setVisionWardsBoughtInGame(int $visionWardsBoughtInGame): self
    {
        $this->visionWardsBoughtInGame = $visionWardsBoughtInGame;

        return $this;
    }

    public function getWardsKilled(): ?int
    {
        return $this->wardsKilled;
    }

    public function setWardsKilled(int $wardsKilled): self
    {
        $this->wardsKilled = $wardsKilled;

        return $this;
    }

    public function getWardsPlaced(): ?int
    {
        return $this->wardsPlaced;
    }

    public function setWardsPlaced(int $wardsPlaced): self
    {
        $this->wardsPlaced = $wardsPlaced;

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
