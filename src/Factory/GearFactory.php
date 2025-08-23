<?php

declare(strict_types=1);

namespace App\Factory;

use App\Entity\Gear;
use App\Entity\User;
use Zenstruck\Foundry\Persistence\PersistentProxyObjectFactory;
use function Zenstruck\Foundry\Persistence\repository;

/**
 * @extends PersistentProxyObjectFactory<Gear>
 */
final class GearFactory extends PersistentProxyObjectFactory
{
    public static function class(): string
    {
        return Gear::class;
    }

    /**
     * @return string[]
     */
    protected function defaults(): array
    {
        return [
            'name' => 'Gear-' . self::faker()->text(20),
            'owner' => repository(User::class)->random(),
        ];
    }
}
