<?php
namespace App\Controller\Admin;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class AdminGamesController extends AbstractController
{
    /**
     * @Route("/admin/games/refresh", name="admin_games_refresh")
     */
    public function adminGamesRefresh()
    {
        if (!$this->getUser()) {
            $this->addFlash("danger", "Tu dois être connecté(e) pour accéder à cette page.");
            return $this->redirectToRoute("login");
        }

        if (!in_array("ROLE_ADMIN", $this->getUser()->getRoles())) {
            $this->addFlash("danger", "Tu ne disposes pas des droits nécessaires pour accéder à cette page.");
            return $this->redirectToRoute("homepage");
        }

        return $this->render("site/pages/admin/games/refresh.html.twig");
    }
}