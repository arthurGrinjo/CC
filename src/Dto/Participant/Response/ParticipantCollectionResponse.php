<?php

namespace App\Dto\Participant\Response;

use ApiPlatform\Doctrine\Orm\State\Options;
use ApiPlatform\Metadata\ApiProperty;
use ApiPlatform\Metadata\ApiResource;
use App\Dto\Event\Response\EventResponse;
use App\Dto\Response;
use App\Dto\User\Response\UserResponse;
use App\Entity\Enum\ParticipantRole;
use App\Entity\Participant;
use Symfony\Component\Serializer\Attribute\SerializedName;
use Symfony\Component\Uid\Uuid;
use Symfony\Component\Validator\Constraints as Assert;

#[ApiResource(
    shortName: 'participant',
    operations: [],
    stateOptions: new Options(entityClass: Participant::class),
)]
final readonly class ParticipantCollectionResponse implements Response
{
    public function __construct(
        #[SerializedName('uuid'), Assert\NotBlank]
        #[ApiProperty(identifier: true)]
        public Uuid $uuid,

        #[SerializedName('role'), Assert\NotBlank]
        public ParticipantRole $role,

        #[SerializedName('user'), Assert\NotBlank]
        public UserResponse $user,

        #[SerializedName('event'), Assert\NotBlank]
        public EventResponse $event,
    ) {}
}