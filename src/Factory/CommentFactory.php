<?php

declare(strict_types=1);

namespace App\Factory;

use App\Entity\Comment;
use App\Entity\Enum\RelatedEntity;
use App\Entity\User;
use Zenstruck\Foundry\Persistence\PersistentProxyObjectFactory;
use function Zenstruck\Foundry\Persistence\repository;

/**
 * @extends PersistentProxyObjectFactory<Comment>
 */
final class CommentFactory extends PersistentProxyObjectFactory
{
    public static function class(): string
    {
        return Comment::class;
    }

    /**
     * @return array<string,mixed>
     */
    protected function defaults(): array
    {
        /** @var RelatedEntity $entityToComment */
        $entityToComment = self::faker()->randomElement(RelatedEntity::cases());

        return [
            'comment' => 'Comment-' . self::faker()->text(),
            'commenter' => repository(User::class)->random(),
            'relatedEntity' => $entityToComment,
            'relatedId' => repository($entityToComment->value)->random()->getId(),
        ];
    }
}
