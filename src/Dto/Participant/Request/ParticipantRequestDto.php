<?php

declare(strict_types=1);

namespace App\Dto\Participant\Request;

use ApiPlatform\Metadata\ApiResource;
use App\Dto\RequestDto;
use App\Entity\Enum\ParticipantRole;
use Symfony\Component\Uid\Uuid;

#[ApiResource(
    shortName: 'participant',
    operations: [],
)]
class ParticipantRequestDto implements RequestDto
{
    public ParticipantRole $role;

    public Uuid $event;

    public Uuid $user;
}
