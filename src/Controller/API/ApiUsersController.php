<?php
namespace App\Controller\API;

use App\Entity\User;
use Exception;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

class ApiUsersController extends AbstractController
{
    /**
     * @Route("/api/users/{id}/riot-ids", name="api_users_riotids", options={"expose"=true})
     * @throws Exception
     */
    public function getRiotIDs(int $id): JsonResponse
    {
        $manager = $this->getDoctrine()->getManager();
        $user = $manager->getRepository(User::class)->find($id);

        if ($user) {
            $response = [
                "id" => $user->getId(),
                "riotAccountId" => $user->getRiotAccountId(),
                "riotId" => $user->getRiotId(),
                "riotPuuid" => $user->getRiotPuuid()
            ];

            return new JsonResponse($response);
        }

        throw new Exception("Utilisateur introuvable.", 404);
    }
}