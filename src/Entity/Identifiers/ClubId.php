<?php

namespace App\Entity\Identifiers;

use App\Entity\Club;
use Symfony\Component\Uid\Uuid;

class ClubId extends Uuid implements IdentifierInterface
{
    const string CLASS_NAME = Club::class;

    public function getClass(): string
    {
        return self::CLASS_NAME;
    }
}
