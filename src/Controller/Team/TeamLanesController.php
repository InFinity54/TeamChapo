<?php
namespace App\Controller\Team;

use App\Entity\Lane;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class TeamLanesController extends AbstractController
{
    /**
     * @Route("/team/lanes", name="team_lanes")
     */
    public function teamLanes()
    {
        $manager = $this->getDoctrine()->getManager();
        $lanes = [
            "top" => $manager->getRepository(Lane::class)->findOneBy(["name" => "Top"]),
            "jungle" => $manager->getRepository(Lane::class)->findOneBy(["name" => "Jungle"]),
            "mid" => $manager->getRepository(Lane::class)->findOneBy(["name" => "Mid"]),
            "adc" => $manager->getRepository(Lane::class)->findOneBy(["name" => "ADC"]),
            "support" => $manager->getRepository(Lane::class)->findOneBy(["name" => "Support"])
        ];
        $fill = $manager->getRepository(Lane::class)->findOneBy(["name" => "Aléatoire"]);

        return $this->render("site/pages/team/lanes.html.twig", [
            "lanes" => $lanes,
            "fill" => $fill
        ]);
    }
}