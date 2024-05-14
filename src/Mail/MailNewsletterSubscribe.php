<?php 

namespace App\Mail;

use App\Entity\Newsletter;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;

class MailNewsletterSubscribe
{
    public function __construct(
        private MailerInterface $mailer,
        private string $adminEmail
    ) {
    }

    public function sendConfirmation(Newsletter $newsletter): void
    {
        $email = (new Email())
        ->from($newsletter->getEmail())
        ->to($this->adminEmail)
        ->subject('Nouvelle inscription à la newsletter')
        ->text($newsletter->getFirstname() . " " . $newsletter->getLastname() . " s'est inscit(e) à la lettre de diffusion.");

        $this->mailer->send($email);
    }

}