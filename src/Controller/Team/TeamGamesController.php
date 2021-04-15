<?php
namespace App\Controller\Team;

use App\Entity\Game;
use App\Entity\GameParticipant;
use App\Entity\GameTeam;
use App\Entity\User;
use App\Services\RiotApiCaller;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class TeamGamesController extends AbstractController
{
    /**
     * @Route("/team/games", name="team_games")
     */
    public function teamLanes(RiotApiCaller $riotApi)
    {
        $manager = $this->getDoctrine()->getManager();
        $games = $manager->getRepository(Game::class)->findBy([], ["startDate" => "DESC"]);
        $formattedGames = [];

        foreach ($games as $game) {
            $formattedGames[] = [
                "infos" => $game,
                "queue" => $riotApi->getQueue($game->getQueueId()),
                "teams" => [
                    100 => [
                        "infos" => $manager->getRepository(GameTeam::class)->findOneBy(["game" => $game, "teamId" => 100]),
                        "isTeamChapo" => $this->teamIsTeamChapo($manager->getRepository(GameTeam::class)->findOneBy(["game" => $game, "teamId" => 100])),
                        "players" => [
                            $manager->getRepository(GameParticipant::class)->findOneBy(["game" => $game, "teamId" => 100, "lane" => "TOP"]),
                            $manager->getRepository(GameParticipant::class)->findOneBy(["game" => $game, "teamId" => 100, "lane" => "JUNGLE"]),
                            $manager->getRepository(GameParticipant::class)->findOneBy(["game" => $game, "teamId" => 100, "lane" => "MIDDLE"]),
                            $manager->getRepository(GameParticipant::class)->findOneBy(["game" => $game, "teamId" => 100, "lane" => "ADC"]),
                            $manager->getRepository(GameParticipant::class)->findOneBy(["game" => $game, "teamId" => 100, "lane" => "SUPPORT"]),
                            $manager->getRepository(GameParticipant::class)->findBy(["game" => $game, "teamId" => 100, "lane" => "NONE"])
                        ]
                    ],
                    200 => [
                        "infos" => $manager->getRepository(GameTeam::class)->findOneBy(["game" => $game, "teamId" => 200]),
                        "isTeamChapo" => $this->teamIsTeamChapo($manager->getRepository(GameTeam::class)->findOneBy(["game" => $game, "teamId" => 200])),
                        "players" => [
                            $manager->getRepository(GameParticipant::class)->findOneBy(["game" => $game, "teamId" => 200, "lane" => "TOP"]),
                            $manager->getRepository(GameParticipant::class)->findOneBy(["game" => $game, "teamId" => 200, "lane" => "JUNGLE"]),
                            $manager->getRepository(GameParticipant::class)->findOneBy(["game" => $game, "teamId" => 200, "lane" => "MIDDLE"]),
                            $manager->getRepository(GameParticipant::class)->findOneBy(["game" => $game, "teamId" => 200, "lane" => "ADC"]),
                            $manager->getRepository(GameParticipant::class)->findOneBy(["game" => $game, "teamId" => 200, "lane" => "SUPPORT"]),
                            $manager->getRepository(GameParticipant::class)->findBy(["game" => $game, "teamId" => 200, "lane" => "NONE"])
                        ]
                    ]
                ]
            ];
        }

        return $this->render("site/pages/team/games/index.html.twig", [
            "games" => $formattedGames
        ]);
    }

    private function teamIsTeamChapo(GameTeam $team): bool
    {
        $manager = $this->getDoctrine()->getManager();
        $playersOfTeam = $manager->getRepository(GameParticipant::class)->findBy(["game" => $team->getGame(), "teamId" => $team->getTeamId()]);

        foreach ($playersOfTeam as $player) {
            if ($manager->getRepository(User::class)->findOneBy(["riotPuuid" => $player->getPuuid()]) !== null) {
                return true;
            }
        }

        return false;
    }
}