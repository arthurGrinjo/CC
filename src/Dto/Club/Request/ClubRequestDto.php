<?php

declare(strict_types=1);

namespace App\Dto\Club\Request;

use App\Dto\RequestDto;
use Symfony\Component\Validator\Constraints as Assert;

class ClubRequestDto implements RequestDto
{
    #[Assert\Length(min: 0, max: 60)]
    public string $name;
}
