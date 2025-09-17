<?php

declare(strict_types=1);

namespace App\Dto\Participant\Request;

use App\Dto\RequestDto;
use App\Entity\Enum\ParticipantRole;
use App\Validation\RegexValidations;
use Symfony\Component\Validator\Constraints as Assert;

class ParticipantRequestDto implements RequestDto
{
    public ParticipantRole $role;

    #[Assert\Regex(RegexValidations::IRI)]
    public string $event;

    #[Assert\Regex(RegexValidations::IRI)]
    public string $user;
}
