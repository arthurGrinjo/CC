<?php

declare(strict_types=1);

namespace App\Dto\Gear\Request;

use App\Dto\RequestDto;
use App\Entity\Gear;
use Symfony\Component\ObjectMapper\Attribute\Map;
use Symfony\Component\Validator\Constraints as Assert;

#[Map(target: Gear::class)]
class GearRequestDto implements RequestDto
{
    #[Assert\Length(min: 0, max: 60)]
    public string $name;
}
