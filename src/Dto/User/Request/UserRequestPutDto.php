<?php

declare(strict_types=1);

namespace App\Dto\User\Request;

use App\Controller\Dto\RequestDto;
use Symfony\Component\Validator\Constraints as Assert;

class UserRequestPutDto implements RequestDto
{
    #[Assert\Length(min: 0, max: 60)]
    public string $firstName;

    #[Assert\Length(min: 0, max: 60)]
    public string $lastName;
}
