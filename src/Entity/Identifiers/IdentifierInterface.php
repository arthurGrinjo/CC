<?php

declare(strict_types=1);

namespace App\Entity\Identifiers;

interface IdentifierInterface
{
    public function getClass(): string;
}
