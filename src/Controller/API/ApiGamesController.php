<?php
namespace App\Controller\API;

use App\Entity\Champion;
use App\Entity\Game;
use App\Entity\GameParticipant;
use App\Entity\GameSkip;
use App\Entity\GameTeam;
use App\Entity\Lane;
use App\Entity\User;
use App\Services\RiotDataDragonQuery;
use DateTime;
use Exception;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class ApiGamesController extends AbstractController
{
    /**
     * @Route("/api/games/{id}/check", name="api_games_isexist", options={"expose"=true})
     * @throws Exception
     */
    public function isGameExistInDatabase(string $id): JsonResponse
    {
        $manager = $this->getDoctrine()->getManager();
        $game = $manager->getRepository(Game::class)->findOneBy(["riotId" => $id]);
        $gameSkipped = $manager->getRepository(GameSkip::class)->findOneBy(["riotId" => $id]);

        if ($game || $gameSkipped) {
            $response = [ "isExist" => true ];
        } else {
            $response = [ "isExist" => false ];
        }

        return new JsonResponse($response);
    }

    /**
     * @Route("/api/games/{id}/save", name="api_games_save", options={"expose"=true})
     * @throws Exception
     */
    public function saveGameInDatabase(string $id, Request $request, RiotDataDragonQuery $riotDataDragon): JsonResponse
    {
        if ($request->request->get("gameData")) {
            try {
                $manager = $this->getDoctrine()->getManager();
                $gameData = json_decode($request->request->get("gameData"), true)["gameData"];
                $game = new Game();

                $gameDurationInSeconds = intdiv((int) $gameData["info"]["gameDuration"],  1000);
                $minutes = sprintf("%02d", intdiv($gameDurationInSeconds, 60));
                $seconds = sprintf("%02d", fmod($gameDurationInSeconds, 60));

                $game->setDuration($minutes . ":" . $seconds);
                $game->setGameVersion($gameData["info"]["gameVersion"]);
                $game->setMapId($gameData["info"]["mapId"]);
                $game->setQueueId($gameData["info"]["queueId"]);
                $game->setRiotId($id);
                $game->setStartDate(new DateTime(date("c", $gameData["info"]["gameStartTimestamp"] / 1000)));

                $manager->persist($game);

                $teamsLanes = [
                    100 => [],
                    200 => []
                ];

                foreach ($gameData["info"]["participants"] as $participantData) {
                    $participant = new GameParticipant();
                    $perks = [
                        "primary" => [
                            "style" => 0,
                            "selections" => []
                        ],
                        "secondary" => [
                            "style" => 0,
                            "selections" => []
                        ]
                    ];

                    foreach ($participantData["perks"]["styles"] as $perk) {
                        if ($perk["description"] === "primaryStyle") {
                            $perks["primary"]["style"] = $perk["style"];

                            foreach ($perk["selections"] as $selection) {
                                $perks["primary"]["selections"][] = implode("|", $selection);
                            }
                        } else {
                            $perks["secondary"]["style"] = $perk["style"];

                            foreach ($perk["selections"] as $selection) {
                                $perks["secondary"]["selections"][] = implode("|", $selection);
                            }
                        }
                    }

                    $lane = $this->determinedPlayerLane($teamsLanes, $participantData);

                    $participant->setAssists($participantData["assists"]);
                    $participant->setBaronKills($participantData["baronKills"]);
                    $participant->setChampion($manager->getRepository(Champion::class)->findOneBy(["normalizedName" => $participantData["championName"]]));
                    $participant->setChampionLevel($participantData["champLevel"]);
                    $participant->setDamageDealtToBuildings($participantData["damageDealtToBuildings"]);
                    $participant->setDamageDealtToObjectives($participantData["damageDealtToObjectives"]);
                    $participant->setDamageDealtToTurrets($participantData["damageDealtToTurrets"]);
                    $participant->setDamageSelfMitigated($participantData["damageSelfMitigated"]);
                    $participant->setDeaths($participantData["deaths"]);
                    $participant->setDoubleKills($participantData["doubleKills"]);
                    $participant->setDragonKills($participantData["dragonKills"]);
                    $participant->setFirstBloodAssist($participantData["firstBloodAssist"]);
                    $participant->setFirstBloodKill($participantData["firstBloodKill"]);
                    $participant->setFirstTowerAssist($participantData["firstTowerAssist"]);
                    $participant->setFirstTowerKill($participantData["firstTowerKill"]);
                    $participant->setGame($game);
                    $participant->setGameEndedInEarlySurrender($participantData["gameEndedInEarlySurrender"]);
                    $participant->setGameEndedInSurrender($participantData["gameEndedInSurrender"]);
                    $participant->setGoldEarned($participantData["goldEarned"]);
                    $participant->setGoldSpent($participantData["goldSpent"]);
                    $participant->setInhibitorKills($participantData["inhibitorKills"]);
                    $participant->setInhibitorsLost($participantData["inhibitorsLost"]);
                    $participant->setItem1($participantData["item0"]);
                    $participant->setItem2($participantData["item1"]);
                    $participant->setItem3($participantData["item2"]);
                    $participant->setItem4($participantData["item3"]);
                    $participant->setItem5($participantData["item4"]);
                    $participant->setItem6($participantData["item5"]);
                    $participant->setKillingSprees($participantData["killingSprees"]);
                    $participant->setKills($participantData["kills"]);
                    $participant->setLane($lane);
                    $participant->setLargestCriticalStrike($participantData["largestCriticalStrike"]);
                    $participant->setLargestKillingSpree($participantData["largestKillingSpree"]);
                    $participant->setLargestMultiKill($participantData["largestMultiKill"]);
                    $participant->setLongestTimeSpentLiving($participantData["longestTimeSpentLiving"]);
                    $participant->setMagicDamageDealt($participantData["magicDamageDealt"]);
                    $participant->setMagicDamageDealtToChampions($participantData["magicDamageDealtToChampions"]);
                    $participant->setMagicDamageTaken($participantData["magicDamageTaken"]);
                    $participant->setNeutralMinionsKilled($participantData["neutralMinionsKilled"]);
                    $participant->setNexusKills($participantData["nexusKills"]);
                    $participant->setObjectivesStolen($participantData["objectivesStolen"]);
                    $participant->setObjectivesStolenAssists($participantData["objectivesStolenAssists"]);
                    $participant->setPentaKills($participantData["pentaKills"]);
                    $participant->setPerksPrimarySelection1($perks["primary"]["selections"][0]);
                    $participant->setPerksPrimarySelection2($perks["primary"]["selections"][1]);
                    $participant->setPerksPrimarySelection3($perks["primary"]["selections"][2]);
                    $participant->setPerksPrimarySelection4($perks["primary"]["selections"][3]);
                    $participant->setPerksPrimaryStyle($perks["primary"]["style"]);
                    $participant->setPerksSecondarySelection1($perks["secondary"]["selections"][0]);
                    $participant->setPerksSecondarySelection2($perks["secondary"]["selections"][1]);
                    $participant->setPerksSecondaryStyle($perks["secondary"]["style"]);
                    $participant->setPerksStatsDefense($participantData["perks"]["statPerks"]["defense"]);
                    $participant->setPerksStatsFlex($participantData["perks"]["statPerks"]["flex"]);
                    $participant->setPerksStatsOffense($participantData["perks"]["statPerks"]["offense"]);
                    $participant->setPhysicalDamageDealt($participantData["physicalDamageDealt"]);
                    $participant->setPhysicalDamageDealtToChampions($participantData["physicalDamageDealtToChampions"]);
                    $participant->setPhysicalDamageTaken($participantData["physicalDamageTaken"]);
                    $participant->setPuuid($participantData["puuid"]);
                    $participant->setQuadraKills($participantData["quadraKills"]);
                    $participant->setSpellACasts($participantData["spell1Casts"]);
                    $participant->setSpellECasts($participantData["spell3Casts"]);
                    $participant->setSpellRCasts($participantData["spell4Casts"]);
                    $participant->setSpellZCasts($participantData["spell2Casts"]);
                    $participant->setSummonerName($participantData["summonerName"]);
                    $participant->setSummonerSpell1Casts($participantData["summoner1Casts"]);
                    $participant->setSummonerSpell1Id($participantData["spell1Id"]);
                    $participant->setSummonerSpell2Casts($participantData["summoner2Casts"]);
                    $participant->setSummonerSpell2Id($participantData["spell2Id"]);
                    $participant->setTeamId($participantData["teamId"]);
                    $participant->setTotalDamageDealt($participantData["totalDamageDealt"]);
                    $participant->setTotalDamageDealtToChampions($participantData["totalDamageDealtToChampions"]);
                    $participant->setTotalDamageShieldedOnTeammates($participantData["totalDamageShieldedOnTeammates"]);
                    $participant->setTotalDamageTaken($participantData["totalDamageTaken"]);
                    $participant->setTotalHeal($participantData["totalHeal"]);
                    $participant->setTotalHealsOnTeammates($participantData["totalHealsOnTeammates"]);
                    $participant->setTotalMinionsKilled($participantData["totalMinionsKilled"]);
                    $participant->setTotalTimeCCDealt($participantData["totalTimeCCDealt"]);
                    $participant->setTotalTimeSpentDead($participantData["totalTimeSpentDead"]);
                    $participant->setTotalUnitsHealed($participantData["totalUnitsHealed"]);
                    $participant->setTripleKills($participantData["tripleKills"]);
                    $participant->setTrueDamageDealt($participantData["trueDamageDealt"]);
                    $participant->setTrueDamageDealtToChampions($participantData["trueDamageDealtToChampions"]);
                    $participant->setTrueDamageTaken($participantData["trueDamageTaken"]);
                    $participant->setTurretKills($participantData["turretKills"]);
                    $participant->setUnrealKills($participantData["unrealKills"]);
                    $participant->setVisionScore($participantData["visionScore"]);
                    $participant->setVisionWardsBoughtInGame($participantData["visionWardsBoughtInGame"]);
                    $participant->setWard($participantData["item6"]);
                    $participant->setWardsKilled($participantData["wardsKilled"]);
                    $participant->setWardsPlaced($participantData["wardsPlaced"]);
                    $participant->setWin($participantData["win"]);

                    $game->addParticipant($participant);
                    $manager->persist($participant);
                }

                foreach ($gameData["info"]["teams"] as $teamData) {
                    $team = new GameTeam();

                    $team->setChampionBan1($manager->getRepository(Champion::class)->findOneBy(["normalizedName" => $riotDataDragon->getChampionNormalizedName($teamData["bans"][0]["championId"])]));
                    $team->setChampionBan2($manager->getRepository(Champion::class)->findOneBy(["normalizedName" => $riotDataDragon->getChampionNormalizedName($teamData["bans"][1]["championId"])]));
                    $team->setChampionBan3($manager->getRepository(Champion::class)->findOneBy(["normalizedName" => $riotDataDragon->getChampionNormalizedName($teamData["bans"][2]["championId"])]));
                    $team->setChampionBan4($manager->getRepository(Champion::class)->findOneBy(["normalizedName" => $riotDataDragon->getChampionNormalizedName($teamData["bans"][3]["championId"])]));
                    $team->setChampionBan5($manager->getRepository(Champion::class)->findOneBy(["normalizedName" => $riotDataDragon->getChampionNormalizedName($teamData["bans"][4]["championId"])]));
                    $team->setFirstBaron($teamData["objectives"]["baron"]["first"]);
                    $team->setFirstBlood($teamData["objectives"]["champion"]["first"]);
                    $team->setFirstDragon($teamData["objectives"]["dragon"]["first"]);
                    $team->setFirstInhibitor($teamData["objectives"]["inhibitor"]["first"]);
                    $team->setFirstRiftHerald($teamData["objectives"]["riftHerald"]["first"]);
                    $team->setFirstTower($teamData["objectives"]["tower"]["first"]);
                    $team->setGame($game);
                    $team->setTeamId($teamData["teamId"]);
                    $team->setTotalBaronKills($teamData["objectives"]["baron"]["first"]);
                    $team->setTotalChampionKills($teamData["objectives"]["champion"]["first"]);
                    $team->setTotalDragonsKills($teamData["objectives"]["dragon"]["first"]);
                    $team->setTotalInhibitorsKills($teamData["objectives"]["inhibitor"]["first"]);
                    $team->setTotalRiftHeraldKills($teamData["objectives"]["riftHerald"]["first"]);
                    $team->setTotalTowersKills($teamData["objectives"]["tower"]["first"]);
                    $team->setWin($teamData["win"]);

                    $game->addTeam($team);
                    $manager->persist($team);
                }

                $manager->flush();

                $response = [
                    "code" => 200,
                    "message" => "Partie enregistrée."
                ];

                return new JsonResponse($response);
            } catch (Exception $e) {
                $response = [
                    "code" => 500,
                    "message" => $e->getMessage()
                ];

                return new JsonResponse($response);
            }
        }

        throw new Exception("Les données de la partie sont introuvables.", 500);
    }

    private function determinedPlayerLane(array &$teamsLanes, array $participant): ?Lane
    {
        if ($participant["lane"] !== "NONE") {
            $manager = $this->getDoctrine()->getManager();
            $user = $manager->getRepository(User::class)->findOneBy(["riotPuuid" => $participant["puuid"]]);

            if ($user && $user->getLane()) {
                if ($participant["lane"] === "TOP" && !in_array("TOP", $teamsLanes[$participant["teamId"]], true) && $user->getLane()->getName() === "Top") {
                    $teamsLanes[$participant["teamId"]][] = "TOP";
                    return $manager->getRepository(Lane::class)->findOneBy(["name" => "Top"]);
                }

                if ($participant["lane"] === "JUNGLE" && !in_array("JUNGLE", $teamsLanes[$participant["teamId"]], true) && $user->getLane()->getName() === "Jungle") {
                    $teamsLanes[$participant["teamId"]][] = "JUNGLE";
                    return $manager->getRepository(Lane::class)->findOneBy(["name" => "Jungle"]);
                }

                if ($participant["lane"] === "MIDDLE" && !in_array("MIDDLE", $teamsLanes[$participant["teamId"]], true) && $user->getLane()->getName() === "Mid") {
                    $teamsLanes[$participant["teamId"]][] = "MIDDLE";
                    return $manager->getRepository(Lane::class)->findOneBy(["name" => "Mid"]);
                }

                if ($participant["lane"] === "BOTTOM") {
                    if ($participant["role"] === "SUPPORT" && !in_array("SUPPORT", $teamsLanes[$participant["teamId"]], true) && $user->getLane()->getName() === "Support") {
                        $teamsLanes[$participant["teamId"]][] = "SUPPORT";
                        return $manager->getRepository(Lane::class)->findOneBy(["name" => "Support"]);
                    }

                    if ($participant["role"] === "CARRY" && !in_array("ADC", $teamsLanes[$participant["teamId"]], true) && $user->getLane()->getName() === "ADC") {
                        $teamsLanes[$participant["teamId"]][] = "ADC";
                        return $manager->getRepository(Lane::class)->findOneBy(["name" => "ADC"]);
                    }
                }
            } else {
                if ($participant["lane"] === "BOTTOM") {
                    if ($participant["role"] === "SUPPORT" && !in_array("SUPPORT", $teamsLanes[$participant["teamId"]], true)) {
                        $teamsLanes[$participant["teamId"]][] = "SUPPORT";
                        return $manager->getRepository(Lane::class)->findOneBy(["name" => "Support"]);
                    }

                    if ($participant["role"] === "CARRY" && !in_array("ADC", $teamsLanes[$participant["teamId"]], true)) {
                        $teamsLanes[$participant["teamId"]][] = "ADC";
                        return $manager->getRepository(Lane::class)->findOneBy(["name" => "ADC"]);
                    }
                }

                if ($participant["lane"] === "TOP" && !in_array("TOP", $teamsLanes[$participant["teamId"]], true)) {
                    $teamsLanes[$participant["teamId"]][] = "TOP";
                    return $manager->getRepository(Lane::class)->findOneBy(["name" => "Top"]);
                }

                if ($participant["lane"] === "JUNGLE" && !in_array("JUNGLE", $teamsLanes[$participant["teamId"]], true)) {
                    $teamsLanes[$participant["teamId"]][] = "JUNGLE";
                    return $manager->getRepository(Lane::class)->findOneBy(["name" => "Jungle"]);
                }

                if ($participant["lane"] === "MIDDLE" && !in_array("MIDDLE", $teamsLanes[$participant["teamId"]], true)) {
                    $teamsLanes[$participant["teamId"]][] = "MIDDLE";
                    return $manager->getRepository(Lane::class)->findOneBy(["name" => "Mid"]);
                }
            }
        }

        return null;
    }


    /**
     * @Route("/api/games/{id}/exclude", name="api_games_saveexclude", options={"expose"=true})
     * @throws Exception
     */
    public function saveGameInExclusion(string $id, Request $request, RiotDataDragonQuery $riotDataDragon): JsonResponse
    {
        $manager = $this->getDoctrine()->getManager();
        $gameExcluded = $manager->getRepository(GameSkip::class)->findOneBy(["riotId" => $id]);

        if (!$gameExcluded) {
            $gameExcluded = new GameSkip();
        }

        $gameExcluded->setRiotId($id);

        $manager->persist($gameExcluded);
        $manager->flush();

        return new JsonResponse(["code" => 200]);
    }
}