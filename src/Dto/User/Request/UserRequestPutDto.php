<?php

declare(strict_types=1);

namespace App\Dto\User\Request;

use App\Dto\Dto;
use App\Dto\RequestDto;
use Symfony\Component\Validator\Constraints as Assert;

class UserRequestPutDto implements RequestDto, DTO
{
    #[Assert\Length(min: 0, max: 60)]
    public string $firstName;

    #[Assert\Length(min: 0, max: 60)]
    public string $lastName;
}