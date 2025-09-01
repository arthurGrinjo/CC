<?php

declare(strict_types=1);

namespace App\Factory;

use App\Entity\Route;
use Zenstruck\Foundry\Persistence\PersistentProxyObjectFactory;

/**
 * @extends PersistentProxyObjectFactory<Route>
 */
final class RouteFactory extends PersistentProxyObjectFactory
{
    public static function class(): string
    {
        return Route::class;
    }

    /**
     * @return string[]
     */
    protected function defaults(): array
    {
        return [
            'name' => 'Route-' . self::faker()->text(20),
        ];
    }
}
