<?php

namespace App\Dto\Participant\Response;

use ApiPlatform\Metadata\ApiResource;
use App\Dto\Event\Response\EventResponse;
use App\Dto\Participant\Participant;
use App\Dto\Response;
use App\Dto\User\Response\UserResponse;
use App\Entity\Enum\ParticipantRole;
use Symfony\Component\Serializer\Attribute\SerializedName;
use Symfony\Component\Uid\Uuid;
use Symfony\Component\Validator\Constraints as Assert;


#[ApiResource(
    operations: [],
    routePrefix: Participant::ROUTE,
)]
class ParticipantResponse implements Response
{
    public function __construct(
        #[SerializedName('id'), Assert\NotBlank]
        public Uuid $uuid,

        #[SerializedName('role'), Assert\NotBlank]
        public ParticipantRole $role,

        #[SerializedName('user'), Assert\NotBlank]
        public UserResponse $user,

        #[SerializedName('event'), Assert\NotBlank]
        public EventResponse $event,
    ) {}
}