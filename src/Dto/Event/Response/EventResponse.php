<?php

namespace App\Dto\Event\Response;

use ApiPlatform\Metadata\ApiResource;
use App\Dto\Event\Event;
use App\Dto\Participant\Response\ParticipantResponse;
use App\Dto\Response;

#[ApiResource(
    operations: [],
    routePrefix: Event::ROUTE,
)]
class EventResponse implements Response
{
    public function __construct(
        private string $uuid,
        private string $name,
    ){
        $this
            ->setId($uuid)
            ->setName($name)
        ;
    }

    /**
     * @return string
     */
    public function getId(): string
    {
        return $this->uuid;
    }

    /**
     * @param string $uuid
     * @return EventResponse
     */
    public function setId(string $uuid): static
    {
        $this->uuid = $uuid;
        return $this;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @param string $name
     * @return EventResponse
     */
    public function setName(string $name): static
    {
        $this->name = $name;
        return $this;
    }
}