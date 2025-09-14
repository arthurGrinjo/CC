<?php

declare(strict_types=1);

namespace App\Dto\Participant\Request;

use ApiPlatform\Metadata\ApiResource;
use App\Dto\RequestDto;
use App\Entity\Enum\ParticipantRole;
use App\Entity\Identifier\EventId;
use App\Entity\Identifier\UserId;

#[ApiResource(
    shortName: 'participant',
    operations: [],
)]
class ParticipantRequestDto implements RequestDto
{
    public ParticipantRole $role;

    public EventId $event;

    public UserId $user;
}
