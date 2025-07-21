<?php

declare(strict_types=1);

namespace App\Dto\Participant\Request;

use ApiPlatform\Metadata\ApiResource;
use App\Dto\Dto;
use App\Dto\RequestDto;
use App\Entity\Enum\ParticipantRole;

#[ApiResource(
    shortName: 'participant',
    operations: [],
    normalizationContext: ['iri_only' => true]
)]
class ParticipantRequestDto implements RequestDto, DTO
{
    public ParticipantRole $role;

    public UserRequestDto $user;
}
