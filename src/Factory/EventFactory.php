<?php

namespace App\Factory;

use App\Entity\Event;
use Zenstruck\Foundry\Persistence\PersistentProxyObjectFactory;

/**
 * @extends PersistentProxyObjectFactory<Event>
 */
final class EventFactory extends PersistentProxyObjectFactory
{
    public static function class(): string
    {
        return Event::class;
    }

    protected function defaults(): array|callable
    {
        return [
            'name' => 'Event-' . self::faker()->text(20),
        ];
    }
}
