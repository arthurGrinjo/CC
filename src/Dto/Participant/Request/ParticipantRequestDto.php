<?php

declare(strict_types=1);

namespace App\Dto\Participant\Request;

use App\Dto\RequestDto;
use App\Entity\Enum\ParticipantRole;
use App\Entity\Event;
use App\Entity\User;
use Symfony\Component\Uid\Uuid;
use Symfony\Component\Validator\Constraints as Assert;

class ParticipantRequestDto implements RequestDto
{
    #[Assert\NotBlank]
    public Event $event;

    #[Assert\NotBlank]
    public User $user;

    public ParticipantRole $role;
}