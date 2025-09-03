<?php

declare(strict_types=1);

namespace App\Factory;

use App\Entity\Activity;
use App\Entity\User;
use Zenstruck\Foundry\Persistence\PersistentProxyObjectFactory;
use function Zenstruck\Foundry\Persistence\repository;

/**
 * @extends PersistentProxyObjectFactory<Activity>
 */
final class ActivityFactory extends PersistentProxyObjectFactory
{
    public static function class(): string
    {
        return Activity::class;
    }

    /**
     * @return array<string, User|string>
     */
    protected function defaults(): array
    {
        return [
            'name' => 'Activity-' . self::faker()->text(20),
            'user' => repository(User::class)->random(),
        ];
    }
}
