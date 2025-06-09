<?php

declare(strict_types=1);

namespace App\Dto\Participant\Response;

use ApiPlatform\Metadata\ApiProperty;
use ApiPlatform\Metadata\ApiResource;
use App\Dto\Event\Response\EventResponse;
use App\Dto\Response;
use App\Dto\User\Response\UserResponse;
use App\Entity\Enum\ParticipantRole;
use App\Entity\Participant;
use Symfony\Component\ObjectMapper\Attribute\Map;
use Symfony\Component\Serializer\Attribute\SerializedName;
use Symfony\Component\Uid\Uuid;
use Symfony\Component\Validator\Constraints as Assert;

#[ApiResource(
    shortName: 'participant',
    operations: [],
)]
#[Map(source: Participant::class)]
final readonly class ParticipantResponse implements Response
{
    public function __construct(
        #[SerializedName('uuid'), Assert\NotBlank]
        #[ApiProperty(readable: false, identifier: true)]
        public Uuid $uuid,

        #[SerializedName('role'), Assert\NotBlank]
        public ParticipantRole $role,

        #[SerializedName('user'), Assert\NotBlank]
        #[ApiProperty(readableLink: true)]
        public UserResponse $user,

        #[SerializedName('event'), Assert\NotBlank]
        #[ApiProperty(readableLink: true)]
        public EventResponse $event,
    ) {}
}