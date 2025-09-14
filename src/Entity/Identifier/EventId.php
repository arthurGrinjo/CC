<?php

namespace App\Entity\Identifier;

use App\Entity\Event;
use Symfony\Component\Uid\Uuid;

class EventId extends Uuid implements IdentifierInterface
{
    const string CLASS_NAME = Event::class;

    public function getClass(): string
    {
        return self::CLASS_NAME;
    }
}
