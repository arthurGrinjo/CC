<?php

declare(strict_types=1);

namespace App\Factory;

use App\Entity\Comment;
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
        return [
            'comment' => 'Comment-' . self::faker()->text(),
            'user' => repository(User::class)->random(),
        ];
    }
}
