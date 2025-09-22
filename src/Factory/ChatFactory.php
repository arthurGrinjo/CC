<?php

declare(strict_types=1);

namespace App\Factory;

use App\Entity\Chat;
use App\Entity\EntityInterface;
use App\Entity\Enum\CommentableEntities;
use RuntimeException;
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
     * @return array<string, string|int|null>
     */
    protected function defaults(): array
    {
        /** @var CommentableEntities $entityToComment */
        $entityToComment = self::faker()->randomElement(CommentableEntities::cases());

        return [
            'entityId' => repository($entityToComment->value)->random()->getId(),
            'entity' => $entityToComment->value,
        ];
    }
}
