<?php

declare(strict_types=1);

namespace App\Dto\Participant\Request;

use ApiPlatform\Metadata\ApiResource;
use App\Dto\Event\Response\EventResponseDto;
use App\Dto\RequestDto;
use App\Dto\User\Response\UserResponseDto;
use App\Entity\Enum\ParticipantRole;
use App\Entity\Event;
use App\Entity\User;

#[ApiResource(
    shortName: 'participant',
    operations: [],
)]
class ParticipantRequestDto implements RequestDto
{
    public ParticipantRole $role;

    public EventResponseDto $event;

    public UserResponseDto $user;
}
