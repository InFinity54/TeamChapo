<?php
namespace App\Controller\Team;

use App\Entity\Game;
use App\Entity\GameParticipant;
use App\Entity\GameSkip;
use App\Entity\GameTeam;
use App\Entity\Lane;
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
                "simplifiedRiotId" => explode("_", $game->getRiotId())[1],
                "infos" => $game,
                "queue" => $riotApi->getQueue($game->getQueueId()),
                "teams" => [
                    100 => [
                        "infos" => $manager->getRepository(GameTeam::class)->findOneBy(["game" => $game, "teamId" => 100]),
                        "isTeamChapo" => $this->teamIsTeamChapo($manager->getRepository(GameTeam::class)->findOneBy(["game" => $game, "teamId" => 100])),
                        "players" => [
                            $manager->getRepository(GameParticipant::class)->findOneBy(["game" => $game, "teamId" => 100, "lane" => $manager->getRepository(Lane::class)->findOneBy(["name" => "Top"])]),
                            $manager->getRepository(GameParticipant::class)->findOneBy(["game" => $game, "teamId" => 100, "lane" => $manager->getRepository(Lane::class)->findOneBy(["name" => "Jungle"])]),
                            $manager->getRepository(GameParticipant::class)->findOneBy(["game" => $game, "teamId" => 100, "lane" => $manager->getRepository(Lane::class)->findOneBy(["name" => "Mid"])]),
                            $manager->getRepository(GameParticipant::class)->findOneBy(["game" => $game, "teamId" => 100, "lane" => $manager->getRepository(Lane::class)->findOneBy(["name" => "ADC"])]),
                            $manager->getRepository(GameParticipant::class)->findOneBy(["game" => $game, "teamId" => 100, "lane" => $manager->getRepository(Lane::class)->findOneBy(["name" => "Support"])]),
                            $manager->getRepository(GameParticipant::class)->findBy(["game" => $game, "teamId" => 100, "lane" => null])
                        ]
                    ],
                    200 => [
                        "infos" => $manager->getRepository(GameTeam::class)->findOneBy(["game" => $game, "teamId" => 200]),
                        "isTeamChapo" => $this->teamIsTeamChapo($manager->getRepository(GameTeam::class)->findOneBy(["game" => $game, "teamId" => 200])),
                        "players" => [
                            $manager->getRepository(GameParticipant::class)->findOneBy(["game" => $game, "teamId" => 200, "lane" => $manager->getRepository(Lane::class)->findOneBy(["name" => "Top"])]),
                            $manager->getRepository(GameParticipant::class)->findOneBy(["game" => $game, "teamId" => 200, "lane" => $manager->getRepository(Lane::class)->findOneBy(["name" => "Jungle"])]),
                            $manager->getRepository(GameParticipant::class)->findOneBy(["game" => $game, "teamId" => 200, "lane" => $manager->getRepository(Lane::class)->findOneBy(["name" => "Mid"])]),
                            $manager->getRepository(GameParticipant::class)->findOneBy(["game" => $game, "teamId" => 200, "lane" => $manager->getRepository(Lane::class)->findOneBy(["name" => "ADC"])]),
                            $manager->getRepository(GameParticipant::class)->findOneBy(["game" => $game, "teamId" => 200, "lane" => $manager->getRepository(Lane::class)->findOneBy(["name" => "Support"])]),
                            $manager->getRepository(GameParticipant::class)->findBy(["game" => $game, "teamId" => 200, "lane" => null])
                        ]
                    ]
                ]
            ];
        }

        return $this->render("site/pages/team/games/index.html.twig", [
            "games" => $formattedGames
        ]);
    }

    /**
     * @Route("/team/games/{id}", name="team_game")
     */
    public function teamGame(string $id, RiotApiCaller $riotApi)
    {
        $manager = $this->getDoctrine()->getManager();
        $game = $manager->getRepository(Game::class)->findOneBy(["riotId" => $id]);
        $gameSkipped = $manager->getRepository(GameSkip::class)->findOneBy(["riotId" => $id]);

        if ($game) {
            return $this->render("site/pages/team/games/detail.html.twig", [
                "game" => [
                    "simplifiedRiotId" => explode("_", $game->getRiotId())[1],
                    "infos" => $game,
                    "queue" => $riotApi->getQueue($game->getQueueId()),
                    "teams" => [
                        100 => [
                            "infos" => $manager->getRepository(GameTeam::class)->findOneBy(["game" => $game, "teamId" => 100]),
                            "isTeamChapo" => $this->teamIsTeamChapo($manager->getRepository(GameTeam::class)->findOneBy(["game" => $game, "teamId" => 100])),
                            "players" => [
                                $manager->getRepository(GameParticipant::class)->findOneBy(["game" => $game, "teamId" => 100, "lane" => $manager->getRepository(Lane::class)->findOneBy(["name" => "Top"])]),
                                $manager->getRepository(GameParticipant::class)->findOneBy(["game" => $game, "teamId" => 100, "lane" => $manager->getRepository(Lane::class)->findOneBy(["name" => "Jungle"])]),
                                $manager->getRepository(GameParticipant::class)->findOneBy(["game" => $game, "teamId" => 100, "lane" => $manager->getRepository(Lane::class)->findOneBy(["name" => "Mid"])]),
                                $manager->getRepository(GameParticipant::class)->findOneBy(["game" => $game, "teamId" => 100, "lane" => $manager->getRepository(Lane::class)->findOneBy(["name" => "ADC"])]),
                                $manager->getRepository(GameParticipant::class)->findOneBy(["game" => $game, "teamId" => 100, "lane" => $manager->getRepository(Lane::class)->findOneBy(["name" => "Support"])]),
                                $manager->getRepository(GameParticipant::class)->findBy(["game" => $game, "teamId" => 100, "lane" => null])
                            ]
                        ],
                        200 => [
                            "infos" => $manager->getRepository(GameTeam::class)->findOneBy(["game" => $game, "teamId" => 200]),
                            "isTeamChapo" => $this->teamIsTeamChapo($manager->getRepository(GameTeam::class)->findOneBy(["game" => $game, "teamId" => 200])),
                            "players" => [
                                $manager->getRepository(GameParticipant::class)->findOneBy(["game" => $game, "teamId" => 200, "lane" => $manager->getRepository(Lane::class)->findOneBy(["name" => "Top"])]),
                                $manager->getRepository(GameParticipant::class)->findOneBy(["game" => $game, "teamId" => 200, "lane" => $manager->getRepository(Lane::class)->findOneBy(["name" => "Jungle"])]),
                                $manager->getRepository(GameParticipant::class)->findOneBy(["game" => $game, "teamId" => 200, "lane" => $manager->getRepository(Lane::class)->findOneBy(["name" => "Mid"])]),
                                $manager->getRepository(GameParticipant::class)->findOneBy(["game" => $game, "teamId" => 200, "lane" => $manager->getRepository(Lane::class)->findOneBy(["name" => "ADC"])]),
                                $manager->getRepository(GameParticipant::class)->findOneBy(["game" => $game, "teamId" => 200, "lane" => $manager->getRepository(Lane::class)->findOneBy(["name" => "Support"])]),
                                $manager->getRepository(GameParticipant::class)->findBy(["game" => $game, "teamId" => 200, "lane" => null])
                            ]
                        ]
                    ]
                ]
            ]);
        }

        if ($gameSkipped) {
            $this->addFlash("danger", "Il n'est pas possible d'afficher le détail des parties ignorées par le système.");
            return $this->redirectToRoute("team_games");
        }

        $this->addFlash("danger", "La partie demandée n'existe pas dans la base de données.");
        return $this->redirectToRoute("team_games");
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