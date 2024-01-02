<?php

namespace App\Dto\User\Request;

use App\Dto\Request;
use Symfony\Component\Validator\Constraints as Assert;

final class ResetPasswordRequest implements Request
{
    #[Assert\Email]
    public string $email;
}