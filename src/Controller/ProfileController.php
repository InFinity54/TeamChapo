<?php
namespace App\Controller;

use App\Entity\User;
use App\Services\AvatarUpload;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class ProfileController extends AbstractController
{
    /**
     * @Route("/profile", name="profile")
     */
    public function profile(Request $request, AvatarUpload $avatarUpload)
    {
        if (!$this->getUser()) {
            $this->addFlash("danger", "Tu dois être connecté(e) pour accéder à cette page.");
            return $this->redirectToRoute("login");
        }

        $manager = $this->getDoctrine()->getManager();
        $user = $manager->getRepository(User::class)->findOneBy(["nickname" => $this->getUser()->getUsername()]);

        if ($user) {
            if ($request->request->count() > 0) {
                $user->setEmail($request->request->get("email"));

                if ($request->files->get("picture")) {
                    $uploadResult = $avatarUpload->upload($request->files->get("picture"), $user);
                    if ($uploadResult !== null) {
                        $user->setPicture($uploadResult);
                        $this->addFlash("success", "La photo de profil a été enregistrée.");
                    } else {
                        $this->addFlash("danger", "Une erreur est survenue durant l'enregistrement de la photo de profil.");
                    }
                }

                $manager->persist($user);
                $manager->flush();

                $this->addFlash("success", "Les modifications ont été enregistrées.");
            }

            return $this->render("site/pages/profile.html.twig", [
                "user" => $user
            ]);
        }

        $this->addFlash("danger", "Le compte n'a pas été trouvé dans la base de données.");
        return $this->redirectToRoute("homepage");
    }
}