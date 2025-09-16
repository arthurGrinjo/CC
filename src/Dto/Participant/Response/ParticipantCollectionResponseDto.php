<?php

declare(strict_types=1);

namespace App\Dto\Participant\Response;

use ApiPlatform\Doctrine\Orm\State\Options;
use ApiPlatform\Metadata\ApiProperty;
use ApiPlatform\Metadata\ApiResource;
use App\Dto\Event\Response\EventResponseDto;
use App\Dto\Participant\Participant;
use App\Dto\ResponseDto;
use App\Dto\User\Response\UserResponseDto;
use App\Entity\Enum\ParticipantRole;
use App\Entity\Participant as ParticipantEntity;
use Symfony\Component\Serializer\Attribute\SerializedName;
use Symfony\Component\Uid\Uuid;
use Symfony\Component\Validator\Constraints as Assert;

#[ApiResource(
    shortName: Participant::SHORT_NAME,
    operations: [],
    stateOptions: new Options(ParticipantEntity::class),
)]
final readonly class ParticipantCollectionResponseDto implements ResponseDto
{
    public function getShortName(): string
    {
        return Participant::SHORT_NAME;
    }

    public function __construct(
        #[SerializedName('uuid'), Assert\NotBlank]
        #[ApiProperty(readable: false, identifier: true)]
        public Uuid             $uuid,

        #[SerializedName('role'), Assert\NotBlank]
        public ParticipantRole  $role,

        #[SerializedName('user'), Assert\NotBlank]
        #[ApiProperty(readableLink: true)]
        public UserResponseDto  $user,

        #[SerializedName('event'), Assert\NotBlank]
        #[ApiProperty(readableLink: true)]
        public EventResponseDto $event,
    ) {}
}
