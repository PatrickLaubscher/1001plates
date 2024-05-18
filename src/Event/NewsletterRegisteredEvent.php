<?php

namespace App\Event;

use App\Entity\Newsletter;

class NewsletterRegisteredEvent
{
    public const NAME = 'newsletter.registered';

    public function __construct(private Newsletter $newsletter)
    {
    }

    public function getNewsletter(): Newsletter
    {
        return $this->newsletter;
    }


}