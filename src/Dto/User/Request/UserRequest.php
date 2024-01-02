<?php

namespace App\Dto\User\Request;

use App\Dto\Request;
use Symfony\Component\Validator\Constraints as Assert;

class UserRequest implements Request
{
    #[Assert\Email]
    public string $email;

    /**
     * todo: Add all fields which are required for creating a user.
     */
}