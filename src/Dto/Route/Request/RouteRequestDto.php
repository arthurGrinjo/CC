<?php

declare(strict_types=1);

namespace App\Dto\Route\Request;

use App\Dto\RequestDto;
use App\Entity\Route;
use Symfony\Component\ObjectMapper\Attribute\Map;
use Symfony\Component\Validator\Constraints as Assert;

#[Map(target: Route::class)]
class RouteRequestDto implements RequestDto
{
    #[Assert\Length(min: 0, max: 60)]
    public string $name;
}
