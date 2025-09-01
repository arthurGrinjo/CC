<?php

declare(strict_types=1);

namespace App\Factory;

use App\Entity\Enum\ParticipantRole;
use App\Entity\Event;
use App\Entity\Participant;
use App\Entity\User;
use Zenstruck\Foundry\Persistence\Exception\NotEnoughObjects;
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
        $participant = $this->createParticipant();

        while (repository(Participant::class)->findOneBy($participant) instanceof Participant) {
            /** re-generate while current combination already exists */
            $participant = $this->createParticipant();
        }

        return array_merge(
            $participant,
            ['role' => self::faker()->randomElement(ParticipantRole::cases())]
        );
    }

    /**
     * @return array{user: User, event: Event}
     * @throws NotEnoughObjects
     */
    private function createParticipant(): array
    {
        return [
            'user' => repository(User::class)->random(),
            'event' => repository(Event::class)->random(),
        ];
    }
}
