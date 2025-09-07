<?php

declare(strict_types=1);

namespace App\Dto\Comment\Request;

use ApiPlatform\Metadata\ApiResource;
use App\Dto\RequestDto;
use App\Entity\Enum\RelatedEntity;
use App\Entity\Identifiers\UserId;

#[ApiResource(
    shortName: 'comment',
    operations: [],
)]
class CommentRequestDto implements RequestDto
{

    public string $comment;

    public UserId $commenter;

    public RelatedEntity $relatedEntity;

    public int $relatedId;
}
