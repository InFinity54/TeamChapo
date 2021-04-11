<?php
namespace App\Controller\Admin;

use App\Entity\User;
use App\Services\EmailSender;
use App\Traits\TokenGenerator;
use DateTime;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Mailer\Exception\TransportExceptionInterface;
use Symfony\Component\Routing\Annotation\Route;

class AdminUsersController extends AbstractController
{
    use TokenGenerator;

    /**
     * @Route("/admin/users", name="admin_users")
     */
    public function adminUsers()
    {
        if (!$this->getUser()) {
            $this->addFlash("danger", "Tu dois être connecté(e) pour accéder à cette page.");
            return $this->redirectToRoute("login");
        }

        if (!in_array("ROLE_ADMIN", $this->getUser()->getRoles())) {
            $this->addFlash("danger", "Tu ne disposes pas des droits nécessaires pour accéder à cette page.");
            return $this->redirectToRoute("homepage");
        }

        $manager = $this->getDoctrine()->getManager();
        $users = $manager->getRepository(User::class)->findBy([], ["nickname" => "ASC"]);

        return $this->render("site/pages/admin/users/index.html.twig", [
            "users" => $users
        ]);
    }

    /**
     * @Route("/admin/users/{id}/enable", name="admin_user_enable")
     */
    public function adminUserEnable(int $id)
    {
        if (!$this->getUser()) {
            $this->addFlash("danger", "Tu dois être connecté(e) pour accéder à cette page.");
            return $this->redirectToRoute("login");
        }

        if (!in_array("ROLE_ADMIN", $this->getUser()->getRoles())) {
            $this->addFlash("danger", "Tu ne disposes pas des droits nécessaires pour accéder à cette page.");
            return $this->redirectToRoute("homepage");
        }

        $manager = $this->getDoctrine()->getManager();
        $user = $manager->getRepository(User::class)->find($id);

        if ($user) {
            $user->setIsActivated(true);

            $manager->persist($user);
            $manager->flush();

            $this->addFlash("success", "L'utilisateur a été correctement activé.");
            return $this->redirectToRoute("admin_users");
        }

        $this->addFlash("danger", "L'utilisateur est introuvable dans la base de données.");
        return $this->redirectToRoute("admin_users");
    }

    /**
     * @Route("/admin/users/{id}/disable", name="admin_user_disable")
     */
    public function adminUserDisable(int $id)
    {
        if (!$this->getUser()) {
            $this->addFlash("danger", "Tu dois être connecté(e) pour accéder à cette page.");
            return $this->redirectToRoute("login");
        }

        if (!in_array("ROLE_ADMIN", $this->getUser()->getRoles())) {
            $this->addFlash("danger", "Tu ne disposes pas des droits nécessaires pour accéder à cette page.");
            return $this->redirectToRoute("homepage");
        }

        $manager = $this->getDoctrine()->getManager();
        $user = $manager->getRepository(User::class)->find($id);

        if ($user) {
            $user->setIsActivated(false);

            $manager->persist($user);
            $manager->flush();

            $this->addFlash("success", "L'utilisateur a été correctement désactivé.");
            return $this->redirectToRoute("admin_users");
        }

        $this->addFlash("danger", "L'utilisateur est introuvable dans la base de données.");
        return $this->redirectToRoute("admin_users");
    }

    /**
     * @Route("/admin/users/{id}/passwordreset", name="admin_user_passwordreset")
     */
    public function adminUserPasswordReset(int $id, EmailSender $emailSender)
    {
        if (!$this->getUser()) {
            $this->addFlash("danger", "Tu dois être connecté(e) pour accéder à cette page.");
            return $this->redirectToRoute("login");
        }

        if (!in_array("ROLE_ADMIN", $this->getUser()->getRoles())) {
            $this->addFlash("danger", "Tu ne disposes pas des droits nécessaires pour accéder à cette page.");
            return $this->redirectToRoute("homepage");
        }

        $manager = $this->getDoctrine()->getManager();
        $user = $manager->getRepository(User::class)->find($id);

        if ($user) {
            if ($user->getEmail() !== null) {
                $user->setToken($this->generateRandomString());
                $user->setTokenExpDate((new DateTime("now"))->modify("+1 hour"));

                $manager->persist($user);
                $manager->flush();

                try {
                    $emailSender->send($user->getEmail(), "Récupération de ton mot de passe", "emails/pages/passwordreset.html.twig", [
                        "user" => $user,
                        "fromAdmin" => true
                    ]);

                    $this->addFlash("success", "L'utilisateur a reçu l'e-mail de réinitialisation de son mot de passe.");
                    return $this->redirectToRoute("admin_users");
                } catch (TransportExceptionInterface $e) {
                    $this->addFlash("danger", "Erreur lors de l'envoi de l'e-mail : " . $e->getMessage());
                    return $this->redirectToRoute("admin_users");
                }
            }

            $this->addFlash("success", "L'utilisateur a été correctement désactivé.");
            return $this->redirectToRoute("admin_users");
        }

        $this->addFlash("danger", "L'utilisateur est introuvable dans la base de données.");
        return $this->redirectToRoute("admin_users");
    }
}