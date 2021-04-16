<?php
namespace App\Controller\Team;

use App\Entity\Champion;
use App\Entity\Pool;
use App\Entity\User;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class TeamPoolController extends AbstractController
{
    /**
     * @Route("/team/pools", name="team_pool")
     */
    public function teamPool()
    {
        $manager = $this->getDoctrine()->getManager();
        $users = $manager->getRepository(User::class)->findAll();

        return $this->render("site/pages/team/pool/index.html.twig", [
            "users" => $users
        ]);
    }

    /**
     * @Route("/team/pools/edit", name="team_pool_edit")
     */
    public function profile(Request $request)
    {
        if (!$this->getUser()) {
            $this->addFlash("danger", "Tu dois être connecté(e) pour accéder à cette page.");
            return $this->redirectToRoute("login");
        }

        $manager = $this->getDoctrine()->getManager();
        $user = $manager->getRepository(User::class)->findOneBy(["nickname" => $this->getUser()->getUsername()]);

        if ($user) {
            $pool = $user->getPool();
            $champions = $manager->getRepository(Champion::class)->findBy([], ["name" => "ASC"]);

            if (!$pool) {
                $pool = new Pool();
            }

            if ($request->request->count() > 0) {
                if ($pool->getUser() === null) {
                    $pool->setUser($user);
                }

                foreach ($pool->getPrimaryPool() as $champion) {
                    $pool->removePrimaryPool($champion);
                }

                foreach ($pool->getSecondaryPool() as $champion) {
                    $pool->removeSecondaryPool($champion);
                }

                foreach ($pool->getExcludedPool() as $champion) {
                    $pool->removeExcludedPool($champion);
                }

                foreach ($request->request->get("primaryPool") as $championId) {
                    $pool->addPrimaryPool($manager->getRepository(Champion::class)->find($championId));
                }

                foreach ($request->request->get("secondaryPool") as $championId) {
                    $pool->addSecondaryPool($manager->getRepository(Champion::class)->find($championId));
                }

                foreach ($request->request->get("excludedPool") as $championId) {
                    $pool->addExcludedPool($manager->getRepository(Champion::class)->find($championId));
                }

                $manager->persist($pool);
                $manager->flush();

                $this->addFlash("success", "Les modifications ont été enregistrées.");
            }

            return $this->render("site/pages/team/pool/edit.html.twig", [
                "pool" => $pool,
                "champions" => $champions
            ]);
        }

        $this->addFlash("danger", "Le compte n'a pas été trouvé dans la base de données.");
        return $this->redirectToRoute("homepage");
    }
}