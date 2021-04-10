<?php
namespace App\Controller\Game;

use App\Entity\Champion;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class GameChampionsController extends AbstractController
{
    /**
     * @Route("/game/champions", name="game_champions")
     */
    public function gameChampions()
    {
        $manager = $this->getDoctrine()->getManager();
        $champions = $manager->getRepository(Champion::class)->findBy([], ["name" => "ASC"]);

        return $this->render("site/pages/game/champions.html.twig", [
            "champions" => $champions
        ]);
    }
}