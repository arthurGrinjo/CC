<?php

declare(strict_types=1);

namespace App\Dto\Member\Request;

use ApiPlatform\Metadata\ApiResource;
use App\Dto\RequestDto;
use App\Entity\Identifier\ClubId;
use App\Entity\Identifier\UserId;

#[ApiResource(
    shortName: 'participant',
    operations: [],
)]
class MemberRequestDto implements RequestDto
{
    public ClubId $club;

    public UserId $user;
}
