<?php

namespace App\EventSubscriber;

use App\Event\NewsletterRegisteredEvent;
use App\Mail\MailNewsletterSubscribe;
use App\Mail\NewsletterSubscribeConfirm;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\Notifier\Bridge\Discord\DiscordOptions;
use Symfony\Component\Notifier\Bridge\Discord\Embeds\DiscordEmbed;
use Symfony\Component\Notifier\Bridge\Discord\Embeds\DiscordFieldEmbedObject;
use Symfony\Component\Notifier\Bridge\Discord\Embeds\DiscordFooterEmbedObject;
use Symfony\Component\Notifier\Bridge\Discord\Embeds\DiscordMediaEmbedObject;
use Symfony\Component\Notifier\ChatterInterface;
use Symfony\Component\Notifier\Message\ChatMessage;

class NewsletterRegisteredSubscriber implements EventSubscriberInterface
{
    public function __construct(
        private NewsletterSubscribeConfirm $newsletterSubscribeConfirm,
        private MailNewsletterSubscribe $mailNewsletterSubscribe,
        private ChatterInterface $chatter
        )
    {}

    public function onNewsletterRegistered(NewsletterRegisteredEvent $event): void
    {
        $email = $event->getNewsletter();
        $this->newsletterSubscribeConfirm->sendConfirmation($email);
        $this->mailNewsletterSubscribe->sendConfirmation($email);
    }

    public function sendDiscordNotification(NewsletterRegisteredEvent $event): void
    {
        $email = $event->getNewsletter();

        $chatMessage = new ChatMessage('');

        $discordOptions = (new DiscordOptions())
            ->username('1001plates')
            ->addEmbed(
                (new DiscordEmbed())
                ->color(2021216)
                ->title('Nouvelle inscription à la newsletter 1001plates')
                ->description('Welcome to ' . $email->getFirstname() . ' ' . $email->getLastname() . ' !')
                ->thumbnail((new DiscordMediaEmbedObject())
                ->url('https://ld-web.github.io/hb-sf-pe8-course/img/logo.png'))
                ->addField(
                    (new DiscordFieldEmbedObject())
                    ->name('Email')
                    ->value($email->getEmail())
                    ->inline(true)
                )
                ->addField(
                    (new DiscordFieldEmbedObject())
                    ->name('Prénom')
                    ->value($email->getFirstname())
                    ->inline(true)
                )
                ->addField(
                    (new DiscordFieldEmbedObject())
                    ->name('Nom')
                    ->value($email->getLastname())
                    ->inline(true)
                )
                ->footer(
                    (new DiscordFooterEmbedObject())
                    ->text('Human Booster - 2024')
                    ->iconUrl('https://ld-web.github.io/hb-sf-pe7-course/img/logo.png')
                )
    
            );
        $chatMessage->options($discordOptions);
        $this->chatter->send($chatMessage);

    }

    
    public static function getSubscribedEvents(): array
    {
        return [
            NewsletterRegisteredEvent::NAME => [
                ['onNewsletterRegistered', 10],
                // ['sendDiscordNotification', 5]
            ]
        ];
    }

}
