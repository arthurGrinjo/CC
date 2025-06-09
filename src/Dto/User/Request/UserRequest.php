<?php

namespace App\Dto\User\Request;

use App\Dto\Request;
use Symfony\Component\Validator\Constraints as Assert;

class UserRequest implements Request
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