<?php

namespace App\Dto;

use App\Entity\TestManager;
use Symfony\Component\ObjectMapper\Attribute\Map;

final readonly class ManagerExtendedDto
{
    public function __construct(
        public ?string $name,
        public int $age,
    ) {}
}
