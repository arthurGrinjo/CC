<?php

declare(strict_types=1);

namespace App\Factory;

use App\Entity\Enum\ParticipantRole;
use App\Entity\Event;
use App\Entity\Participant;
use App\Entity\User;
use Zenstruck\Foundry\Persistence\PersistentProxyObjectFactory;
use function Zenstruck\Foundry\Persistence\repository;

/**
 * @extends PersistentProxyObjectFactory<Participant>
 */
final class ParticipantFactory extends PersistentProxyObjectFactory
{
    public static function class(): string
    {
        return Participant::class;
    }

    /**
     * @return array<string,mixed>
     */
    protected function defaults(): array
    {
        return [
            'user' => repository(User::class)->random(),
            'event' => repository(Event::class)->random(),
            'role' => self::faker()->randomElement(ParticipantRole::cases()),
        ];
    }
}
