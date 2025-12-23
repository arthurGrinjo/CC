<?php

declare(strict_types=1);

namespace App\Dto\Location\Request;

use App\Dto\RequestDto;
use App\Entity\Location;
use Symfony\Component\ObjectMapper\Attribute\Map;
use Symfony\Component\Validator\Constraints as Assert;

#[Map(target: Location::class)]
class LocationRequestDto implements RequestDto
{
    #[Assert\Length(min: 0, max: 60)]
    public string $name;
}
