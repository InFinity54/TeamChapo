<?php
namespace App\Services;

use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Component\Mailer\Exception\TransportExceptionInterface;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Address;

class EmailSender
{
    private $mailer;

    public function __construct(MailerInterface $mailer)
    {
        $this->mailer = $mailer;
    }

    /**
     * @param string $to
     * @param string $subject
     * @param string $template
     * @param array $context
     * @return void
     * @throws TransportExceptionInterface
     */
    public function send(string $to, string $subject, string $template, array $context): void
    {
        $email = (new TemplatedEmail())
            ->from($_ENV["TEAMCHAPO_SENDMAIL"])
            ->to(new Address($to))
            ->subject($subject)
            ->htmlTemplate($template)
            ->context($context)
        ;

        $this->mailer->send($email);
    }
}