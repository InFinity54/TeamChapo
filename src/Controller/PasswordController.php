<?php
namespace App\Controller;

use App\Entity\User;
use App\Services\EmailSender;
use App\Traits\TokenGenerator;
use DateTime;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Mailer\Exception\TransportExceptionInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class PasswordController extends AbstractController
{
    use TokenGenerator;

    /**
     * @Route("/password", name="password")
     */
    public function password(Request $request, EmailSender $emailSender): Response
    {
        if ($this->getUser()) {
            $this->addFlash("success", "Tu es déjà connecté(e). Accède à ton profil pour changer ton mot de passe !");
            return $this->redirectToRoute('homepage');
        }

        if ($request->request->count() > 0) {
            $manager = $this->getDoctrine()->getManager();
            $user = $manager->getRepository(User::class)->findOneBy(["nickname" => $request->request->get("nickname")]);

            if ($user) {
                if ($user->getEmail() !== null) {
                    $user->setToken($this->generateRandomString());
                    $user->setTokenExpDate((new DateTime("now"))->modify("+1 hour"));

                    $manager->persist($user);
                    $manager->flush();

                    try {
                        $emailSender->send($user->getEmail(), "Récupération de ton mot de passe", "emails/pages/passwordreset.html.twig", [
                            "user" => $user
                        ]);

                        return $this->render('auth/pages/passwordlinksent.html.twig');
                    } catch (TransportExceptionInterface $e) {
                        $this->addFlash("danger", "Erreur lors de l'envoi de l'e-mail : " . $e->getMessage());
                        return $this->redirectToRoute("password");
                    }
                }

                $this->addFlash("danger", "Aucune adresse e-mail n'a été définie pour cet utilisateur.");
                return $this->redirectToRoute("password");
            }

            $this->addFlash("danger", "Aucun utilisateur n'a été trouvé avec ce pseudo.");
            return $this->redirectToRoute("password");
        }

        return $this->render('auth/pages/password.html.twig');
    }

    /**
     * @Route("/passwordreset/{userId}/{token}", name="password_reset")
     */
    public function passwordReset(int $userId, string $token, Request $request, UserPasswordEncoderInterface $encoder): Response
    {
        if ($this->getUser()) {
            $this->addFlash("success", "Tu es déjà connecté(e). Accède à ton profil pour changer ton mot de passe !");
            return $this->redirectToRoute('homepage');
        }

        if ($token !== null && $token !== "") {
            $manager = $this->getDoctrine()->getManager();
            $user = $manager->getRepository(User::class)->find($userId);

            if ($user) {
                if ($user->getToken() === $token) {
                    if (new DateTime("now") < $user->getTokenExpDate()) {
                        if ($request->request->count() > 0) {
                            if ($request->request->get("newpassword") === $request->request->get("confirmnewpassword")) {
                                $user->setPassword($encoder->encodePassword($user, $request->request->get("newpassword")));
                                $user->setToken(null);
                                $user->setTokenExpDate(null);
                                $user->setLastUpdateAt(new DateTime("now"));

                                $manager->persist($user);
                                $manager->flush();

                                $this->addFlash("success", "Le mot de passe a été correctement modifié.");
                                return $this->redirectToRoute("login");
                            }

                            $this->addFlash("danger", "Les mots de passe ne correspondent pas.");
                            return $this->redirectToRoute("password_reset", [
                                "token" => $user->getToken()
                            ]);
                        }

                        return $this->render('auth/pages/passwordreset.html.twig');
                    }

                    $this->addFlash("danger", "Le jeton d'authentification a expiré.");
                    return $this->redirectToRoute("password");
                }

                $this->addFlash("danger", "Le jeton d'authentification est invalide pour l'utilisateur sélectionné.");
                return $this->redirectToRoute("password");
            }

            $this->addFlash("danger", "Le jeton d'authentification n'a pas été trouvé dans la base de données.");
            return $this->redirectToRoute("password");
        }

        $this->addFlash("danger", "Aucun jeton d'authentification valide n'a été détecté.");
        return $this->redirectToRoute("password");
    }
}