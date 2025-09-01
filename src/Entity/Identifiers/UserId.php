<?php

namespace App\Entity\Identifiers;

use App\Entity\User;
use Symfony\Component\Uid\Uuid;

class UserId extends Uuid implements IdentifierInterface
{
    const string CLASS_NAME = User::class;

    public function getClass(): string
    {
        return self::CLASS_NAME;
    }
}
