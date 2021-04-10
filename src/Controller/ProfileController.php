<?php
namespace App\Controller;

use App\Entity\User;
use App\Services\AvatarUpload;
use DateTime;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

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

    /**
     * @Route("/profile/password", name="profile_password")
     */
    public function profilePassword(Request $request, UserPasswordEncoderInterface $encoder)
    {
        if (!$this->getUser()) {
            $this->addFlash("danger", "Tu dois être connecté(e) pour accéder à cette page.");
            return $this->redirectToRoute("login");
        }

        if ($request->request->count() > 0) {
            $manager = $this->getDoctrine()->getManager();
            $user = $manager->getRepository(User::class)->findOneBy(["nickname" => $this->getUser()->getUsername()]);

            if ($user) {
                if ($request->request->get("newpassword") === $request->request->get("confirmnewpassword")) {
                    if ($encoder->isPasswordValid($user, $request->request->get("oldpassword"))) {
                        $user->setPassword($encoder->encodePassword($user, $request->request->get("newpassword")));
                        $user->setLastUpdateAt(new DateTime("now"));

                        $manager->persist($user);
                        $manager->flush();

                        $this->addFlash("success", "Le mot de passe a été correctement modifié.");
                        return $this->redirectToRoute("profile_password");
                    }

                    $this->addFlash("danger", "Le mot de passe actuel est incorrect.");
                    return $this->redirectToRoute("profile_password");
                }

                $this->addFlash("danger", "Les mots de passe ne correspondent pas.");
                return $this->redirectToRoute("profile_password");
            }

            $this->addFlash("danger", "Le compte n'a pas été trouvé dans la base de données.");
            return $this->redirectToRoute("homepage");
        }

        return $this->render("site/pages/password.html.twig");
    }
}