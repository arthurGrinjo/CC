<?php

declare(strict_types=1);

namespace App\Dto\Comment\Request;

use App\Dto\RequestDto;
use App\Validation\RegexValidations;
use Symfony\Component\Validator\Constraints as Assert;

class CommentRequestDto implements RequestDto
{
    #[Assert\Length(min: 3, max: 1024)]
    public string $comment;

    #[Assert\Regex(RegexValidations::IRI)]
    public string $user;

    #[Assert\Regex(RegexValidations::IRI)]
    public string $entity;
}
