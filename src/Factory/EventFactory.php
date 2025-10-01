<?php

declare(strict_types=1);

namespace App\Factory;

use App\Entity\Event;
use App\Entity\Location;
use Exception;
use Zenstruck\Foundry\Persistence\PersistentProxyObjectFactory;
use function Zenstruck\Foundry\Persistence\repository;

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
     * @throws Exception
     */
    protected function defaults(): array
    {
        $startDate = self::faker()->dateTimeBetween('-1 year', '+1 year');;

        return [
            'name' => 'Event-' . self::faker()->text(20),
            'startDatetime' => $startDate,
            'endDatetime' => self::faker()->dateTimeInInterval($startDate, '+6 days'),
            'location' => (rand(0, 1) === 1) ? repository(Location::class)->random() : null,
        ];
    }
}
