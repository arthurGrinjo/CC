<?php

declare(strict_types=1);

namespace App\Dto\User\Request;

use App\Dto\Dto;
use App\Dto\RequestDto;
use Symfony\Component\Validator\Constraints as Assert;

class UserRequestDto implements RequestDto, DTO
{
    #[Assert\Email]
    public string $email;

    #[Assert\Length(min: 8, max: 32)]
    public string $password;

    #[Assert\Length(min: 0, max: 60)]
    public string $firstName;

    #[Assert\Length(min: 0, max: 60)]
    public string $lastName;
}