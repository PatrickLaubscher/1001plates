<?php 

namespace App\Mail;

use App\Entity\Newsletter;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;

class NewsletterSubscribeConfirm
{
    public function __construct(
        private MailerInterface $mailer,
        private string $adminEmail
    ) {
    }

    public function sendConfirmation(Newsletter $newsletter): void
    {
        $email = (new Email())
        ->from($this->adminEmail)
        ->to($newsletter->getEmail())
        ->subject('Confirmation inscription à la newsletter')
        ->text("Bonjour " . $newsletter->getFirstname() . " " . $newsletter->getLastname() . " vous êtes bien inscrit(e) à la lettre de diffusion.");

        $this->mailer->send($email);
    }

}