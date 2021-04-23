<?php
namespace App\Controller\API;

use App\Entity\User;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

class ApiTeamController extends AbstractController
{
    /**
     * @Route("/api/users/state", name="api_team_state", options={"expose"=true})
     */
    public function getTeamState(int $id): JsonResponse
    {
        $manager = $this->getDoctrine()->getManager();
        $users = $manager->getRepository(User::class)->find($id);
        $response = [
            "isComplete" => false,
            "players" => [
                "top" => null,
                "jungle" => null,
                "middle" => null,
                "adc" => null,
                "support" => null
            ]
        ];

        if ($users) {
            foreach ($users as $user) {
                if ($user->getLane() !== null) {
                    switch ($user->getLane()->getName()) {
                        default:
                            break;
                        case "Top":
                            $response["players"]["top"] = $user;
                            break;
                        case "Jungle":
                            $response["players"]["jungle"] = $user;
                            break;
                        case "Mid":
                            $response["players"]["middle"] = $user;
                            break;
                        case "ADC":
                            $response["players"]["adc"] = $user;
                            break;
                        case "Support":
                            $response["players"]["support"] = $user;
                            break;
                    }
                }
            }

            if ($response["players"]["top"] !== null && $response["players"]["jungle"] !== null
                && $response["players"]["middle"] !== null && $response["players"]["adc"] !== null
                && $response["players"]["support"] !== null) {
                $response["isComplete"] = true;
            }
        }

        return new JsonResponse($response);
    }
}