<?php
namespace App\Services;

use Swift_Image;
use Swift_Mailer;
use Swift_Message;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Mime\Address;

class EmailSender extends AbstractController
{
    private $mailer;

    public function __construct(Swift_Mailer $mailer)
    {
        $this->mailer = $mailer;
    }

    /**
     * @param string $to
     * @param string $subject
     * @param string $template
     * @param array $context
     * @return void
     */
    public function send(string $to, string $subject, string $template, array $context): void
    {
        $email = (new Swift_Message())
            ->setSender($_ENV["TEAMCHAPO_SENDMAIL"])
            ->setTo($to)
            ->setSubject($subject)
        ;

        $context["teamchapo"]["logo"] = $email->embed(Swift_Image::fromPath('assets/img/teamchapo_logo.png'));
        $context["teamchapo"]["subject"] = $subject;

        $email->setBody($this->renderView($template, $context), 'text/html');

        $this->mailer->send($email);
    }
}