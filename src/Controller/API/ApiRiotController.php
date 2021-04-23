<?php
namespace App\Controller\API;

use App\Entity\User;
use App\Services\RiotApiCaller;
use DateTime;
use Exception;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class ApiRiotController extends AbstractController
{
    /**
     * @Route("/api/riot/games/{start}/{count}", name="api_riot_games_get", options={"expose"=true})
     * @throws Exception
     */
    public function getGamesFromRiotAPI(int $start, int $count, Request $request, RiotApiCaller $riotApi): JsonResponse
    {
        if ($request->query->get("puuid")) {
            $response = [];
            $gamesList = $riotApi->getMatchlistFromSummoner("EUW", $request->query->get("puuid"), $start, $count);

            if (count($gamesList) > 0) {
                $response["hasGames"] = true;
                $response["matches"] = $gamesList;
            } else {
                $response["hasGames"] = false;
            }

            return new JsonResponse($response);
        }

        throw new Exception("L'identifiant unique global du compte Riot Games n'a pas été renseigné.", 403);
    }

    /**
     * @Route("/api/riot/game/{id}", name="api_riot_game", options={"expose"=true})
     * @throws Exception
     */
    public function getGameFromRiotAPI(string $id, Request $request, RiotApiCaller $riotApi): JsonResponse
    {
        $response["gameData"] = $riotApi->getMatchById("EUW", $id);
        $response["queue"] = $riotApi->getQueue($response["gameData"]["info"]["queueId"]);

        $gameStartDate = date("c", $response["gameData"]["info"]["gameStartTimestamp"] / 1000);

        if ($this->gameHasAllTeamPlayers($response["gameData"]["metadata"]["participants"])
            && in_array($response["gameData"]["info"]["queueId"], $riotApi->getAutorizedQueuesIDs(), true)
            && new DateTime("2021-03-25T19:00:00+02:00") <= new DateTime($gameStartDate)) {
            $response["isValid"] = true;
        } else {
            $response["isValid"] = false;
        }

        return new JsonResponse($response);
    }

    private function gameHasAllTeamPlayers(array $participants): bool
    {
        $manager = $this->getDoctrine()->getManager();
        $users = $manager->getRepository(User::class)->getActualTeamMembers();

        $puuidFromTeam = [];

        foreach ($users as $user) {
            if (in_array($user->getRiotPuuid(), $participants, true)) {
                $puuidFromTeam[] = $user->getRiotPuuid();
            }
        }

        return count($puuidFromTeam) === 5;
    }
}