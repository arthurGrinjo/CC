<?php

declare(strict_types=1);

namespace App\Dto\Member\Request;

use ApiPlatform\Metadata\ApiResource;
use App\Dto\RequestDto;
use App\Entity\Identifiers\ClubId;
use App\Entity\Identifiers\UserId;

#[ApiResource(
    shortName: 'participant',
    operations: [],
)]
class MemberRequestDto implements RequestDto
{
    public ClubId $club;

    public UserId $user;
}
