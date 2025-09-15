<?php

declare(strict_types=1);

namespace App\Dto\Comment\Request;

use ApiPlatform\Metadata\ApiResource;
use App\Dto\RequestDto;
use App\Entity\Identifier\UserId;
use App\Validation\RegexValidations;
use Symfony\Component\Validator\Constraints as Assert;

#[ApiResource(
    shortName: 'comment',
    operations: [],
)]
class CommentRequestDto implements RequestDto
{
    #[Assert\Length(min: 3, max: 1024)]
    public string $comment;

    #[Assert\Regex(RegexValidations::UUID)]
    public UserId $user;

    #[Assert\Regex(RegexValidations::URI)]
    public string $entity;
}
