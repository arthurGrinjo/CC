<?php

declare(strict_types=1);

namespace App\Factory;

use App\Entity\Chat;
use App\Entity\Enum\RelatedEntity;
use Zenstruck\Foundry\Persistence\PersistentProxyObjectFactory;
use function Zenstruck\Foundry\Persistence\repository;

/**
 * @extends PersistentProxyObjectFactory<Chat>
 */
final class ChatFactory extends PersistentProxyObjectFactory
{
    public static function class(): string
    {
        return Chat::class;
    }

    /**
     * @return string[]
     */
    protected function defaults(): array
    {
        /** @var RelatedEntity $entityToComment */
        $entityToComment = self::faker()->randomElement(RelatedEntity::cases());

        return [
            'entityId' => repository($entityToComment->value)->random()->getId(),
            'entity' => $entityToComment->value,
        ];
    }
}
