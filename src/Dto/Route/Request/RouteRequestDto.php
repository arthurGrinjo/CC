<?php

declare(strict_types=1);

namespace App\Dto\Route\Request;

use App\Dto\RequestDto;
use Symfony\Component\Validator\Constraints as Assert;

class RouteRequestDto implements RequestDto
{
    #[Assert\Length(min: 0, max: 60)]
    public string $name;
}
