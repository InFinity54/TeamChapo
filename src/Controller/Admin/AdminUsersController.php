<?php
namespace App\Controller\Admin;

use App\Entity\Lane;
use App\Entity\User;
use App\Services\EmailSender;
use App\Traits\TokenGenerator;
use DateTime;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Mailer\Exception\TransportExceptionInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

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
     * @Route("/admin/users/new", name="admin_user_new")
     */
    public function adminUserNew(Request $request, UserPasswordEncoderInterface $encoder, EmailSender $emailSender)
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
        $lanes = $manager->getRepository(Lane::class)->findAll();

        if ($request->request->count() > 0) {
            $password = $this->generateRandomString(15);
            $user = new User();
            $now = new DateTime();

            $user->setNickname($request->request->get("nickname"));
            $user->setPassword($encoder->encodePassword($user, $password));
            $user->setEmail($request->request->get("email"));
            $user->setLane($manager->getRepository(Lane::class)->find($request->request->get("lane")));
            $user->setIsActivated(true);
            $user->setRegisterAt($now);
            $user->setLastUpdateAt($now);

            $manager->persist($user);
            $manager->flush();

            try {
                $emailSender->send($user->getEmail(), "Ton compte a été créé", "emails/pages/accountcreated.html.twig", [
                    "user" => $user,
                    "password" => $password
                ]);

                $this->addFlash("success", "Le compte utilisateur a été créé.");
                return $this->redirectToRoute("admin_users");
            } catch (TransportExceptionInterface $e) {
                $this->addFlash("danger", "Erreur lors de l'envoi de l'e-mail : " . $e->getMessage());
                return $this->redirectToRoute("admin_user_new");
            }
        }

        return $this->render("site/pages/admin/users/user.new.html.twig", [
            "lanes" => $lanes
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