<?php

declare(strict_types=1);

namespace App\Dto\Event\Request;

use App\Dto\RequestDto;
use App\Entity\Event;
use Symfony\Component\ObjectMapper\Attribute\Map;
use Symfony\Component\Validator\Constraints as Assert;

#[Map(target: Event::class)]
class EventRequestDto implements RequestDto
{
    #[Assert\Length(min: 0, max: 60)]
    public string $name;
}
