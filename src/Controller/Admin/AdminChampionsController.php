<?php
namespace App\Controller\Admin;

use App\Entity\Champion;
use Exception;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class AdminChampionsController extends AbstractController
{
    /**
     * @Route("/admin/champions/refresh", name="admin_champions_refresh")
     */
    public function adminChampionsRefresh()
    {
        if (!$this->getUser()) {
            $this->addFlash("danger", "Tu dois être connecté(e) pour accéder à cette page.");
            return $this->redirectToRoute("login");
        }

        if (!in_array("ROLE_ADMIN", $this->getUser()->getRoles())) {
            $this->addFlash("danger", "Tu ne disposes pas des droits nécessaires pour accéder à cette page.");
            return $this->redirectToRoute("homepage");
        }

        try {
            $manager = $this->getDoctrine()->getManager();
            $championsData = json_decode(file_get_contents($this->getParameter("kernel.project_dir") . "/public/riot/lol/latest/data/fr_FR/champion.json"), true)["data"];

            foreach ($championsData as $championData) {
                $champion = $manager->getRepository(Champion::class)->findOneBy(["name" => $championData["name"]]);

                if (!$champion) {
                    $champion = new Champion();
                }

                $champion->setName($championData["name"]);
                $champion->setNormalizedName($championData["id"]);
                $champion->setImage(strtolower($championData["id"]) . "_0.jpg");

                $manager->persist($champion);
            }

            $manager->flush();
            $this->addFlash("success", "La liste des champions de League of Legends à été actualisée.");
        } catch (Exception $e) {
            $this->addFlash("danger", "Erreur durant l'actualisation de la liste des champions de League of Legends : " . $e->getMessage());
        }

        return $this->redirectToRoute("game_champions");
    }
}