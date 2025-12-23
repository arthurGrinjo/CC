<?php

namespace App\Dto;

use App\Dto\Location\Response\LocationResponseDto;
use App\Entity\TestUser;
use Symfony\Component\ObjectMapper\Attribute\Map;

#[Map(source: TestUser::class)] // can also define mapping here
final readonly class UserDto
{
    public function __construct(
        public string $name = '',
        public ?LocationResponseDto $location,
    ) {}
}
