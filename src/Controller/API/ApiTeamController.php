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
    public function getTeamState(): JsonResponse
    {
        $manager = $this->getDoctrine()->getManager();
        $users = $manager->getRepository(User::class)->findAll();
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
            /**
             * @var User $user
             */
            foreach ($users as $user) {
                if ($user->getLane() !== null) {
                    switch ($user->getLane()->getName()) {
                        default:
                            break;
                        case "Top":
                            $response["players"]["top"] = $user->getNickname();
                            break;
                        case "Jungle":
                            $response["players"]["jungle"] = $user->getNickname();
                            break;
                        case "Mid":
                            $response["players"]["middle"] = $user->getNickname();
                            break;
                        case "ADC":
                            $response["players"]["adc"] = $user->getNickname();
                            break;
                        case "Support":
                            $response["players"]["support"] = $user->getNickname();
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