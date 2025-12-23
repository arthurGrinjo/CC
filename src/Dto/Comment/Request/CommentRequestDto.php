<?php

declare(strict_types=1);

namespace App\Dto\Comment\Request;

use App\Dto\RequestDto;
use App\Entity\Comment;
use App\Validation\RegexValidations;
use Symfony\Component\ObjectMapper\Attribute\Map;
use Symfony\Component\Validator\Constraints as Assert;

#[Map(target: Comment::class)]
class CommentRequestDto implements RequestDto
{
    #[Assert\Length(min: 3, max: 1024)]
    public string $comment;

    #[Assert\Regex(RegexValidations::IRI)]
    public string $user;

    #[Assert\Regex(RegexValidations::IRI)]
    public string $entity;
}
