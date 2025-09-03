<?php

declare(strict_types=1);

namespace App\Factory;

use App\Entity\Club;
use App\Entity\Member;
use App\Entity\User;
use Zenstruck\Foundry\Persistence\Exception\NotEnoughObjects;
use Zenstruck\Foundry\Persistence\PersistentProxyObjectFactory;
use function Zenstruck\Foundry\Persistence\repository;

/**
 * @extends PersistentProxyObjectFactory<Member>
 */
final class MemberFactory extends PersistentProxyObjectFactory
{
    public static function class(): string
    {
        return Member::class;
    }

    /**
     * @return array<string,mixed>
     */
    protected function defaults(): array
    {
        $member = $this->createMember();

        while (repository(Member::class)->findOneBy($member) instanceof Member) {
            /** re-generate while current combination already exists */
            $member = $this->createMember();
        }

        return array_merge(
            $member,
        );
    }

    /**
     * @return array{user: User, club: Club}
     * @throws NotEnoughObjects
     */
    private function createMember(): array
    {
        return [
            'club' => repository(Club::class)->random(),
            'user' => repository(User::class)->random(),
        ];
    }
}
