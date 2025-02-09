<?php

namespace App\Dto\Event\Response;

use ApiPlatform\Metadata\ApiResource;
use App\Dto\Event\Event;
use App\Dto\Participant\Response\ParticipantResponse;
use App\Dto\Response;
use Symfony\Component\Serializer\Attribute\SerializedName;
use Symfony\Component\Uid\Uuid;
use Symfony\Component\Validator\Constraints as Assert;

#[ApiResource(
    operations: [],
    routePrefix: Event::ROUTE,
)]
class EventResponse implements Response
{
    public function __construct(
        #[SerializedName('id'), Assert\NotBlank]
        public Uuid $uuid,

        #[SerializedName('name'), Assert\NotBlank]
        public string $name,
    ) {}
}