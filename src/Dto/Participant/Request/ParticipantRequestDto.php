<?php

declare(strict_types=1);

namespace App\Dto\Participant\Request;

use App\Dto\RequestDto;
use App\Entity\Enum\ParticipantRole;
use App\Entity\Participant;
use App\Validation\RegexValidations;
use Symfony\Component\ObjectMapper\Attribute\Map;
use Symfony\Component\Validator\Constraints as Assert;

#[Map(target: Participant::class)]
class ParticipantRequestDto implements RequestDto
{
    public ParticipantRole $role;

    #[Assert\Regex(RegexValidations::IRI)]
    public string $event;

    #[Assert\Regex(RegexValidations::IRI)]
    public string $user;
}
