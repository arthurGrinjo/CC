<?php

declare(strict_types=1);

namespace App\Dto\Club\Request;

use App\Dto\RequestDto;
use App\Entity\Club;
use Symfony\Component\ObjectMapper\Attribute\Map;
use Symfony\Component\Validator\Constraints as Assert;

#[Map(target: Club::class)]
class ClubRequestDto implements RequestDto
{
    #[Assert\Length(min: 0, max: 60)]
    public string $name;
}
