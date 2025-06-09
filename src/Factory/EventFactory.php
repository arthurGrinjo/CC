<?php

declare(strict_types=1);

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

    /**
     * @return string[]
     */
    protected function defaults(): array
    {
        return [
            'name' => 'Event-' . self::faker()->text(20),
        ];
    }
}
