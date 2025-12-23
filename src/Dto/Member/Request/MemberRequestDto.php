<?php

declare(strict_types=1);

namespace App\Dto\Member\Request;

use App\Dto\RequestDto;
use App\Entity\Member;
use App\Validation\RegexValidations;
use Symfony\Component\ObjectMapper\Attribute\Map;
use Symfony\Component\Validator\Constraints as Assert;

#[Map(target: Member::class)]
class MemberRequestDto implements RequestDto
{
    #[Assert\Regex(RegexValidations::IRI)]
    public string $club;

    #[Assert\Regex(RegexValidations::IRI)]
    public string $user;
}
