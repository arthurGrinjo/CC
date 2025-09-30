<?php

declare(strict_types=1);

namespace App\Factory;

use App\Entity\Location;
use Zenstruck\Foundry\Persistence\PersistentProxyObjectFactory;

/**
 * @extends PersistentProxyObjectFactory<Location>
 */
final class LocationFactory extends PersistentProxyObjectFactory
{
    public static function class(): string
    {
        return Location::class;
    }

    /**
     * @return string[]
     */
    protected function defaults(): array
    {
        return [
            'name' => 'Location-' . self::faker()->text(20),
        ];
    }
}
