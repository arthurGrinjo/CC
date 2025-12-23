<?php

namespace App\Dto;

use App\Entity\TestManager;
use Symfony\Component\ObjectMapper\Attribute\Map;

#[Map(source: Location::class)]
final readonly class ManagerDto
{
    public function __construct(
        public ?string $name,
    ) {}
}
