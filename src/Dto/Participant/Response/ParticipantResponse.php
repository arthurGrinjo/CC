<?php

namespace App\Dto\Participant\Response;

use ApiPlatform\Metadata\ApiResource;
use App\Dto\Event\Response\EventResponse;
use App\Dto\Participant\Participant;
use App\Dto\Response;
use App\Dto\User\Response\UserResponse;


#[ApiResource(
    operations: [],
    routePrefix: Participant::ROUTE,
)]
class ParticipantResponse implements Response
{
    public function __construct(
        private string        $uuid,
        private string        $role,
        private UserResponse  $user,
        private EventResponse $event,
    ){
        $this
            ->setId($uuid)
            ->setRole($role)
            ->setUserResponse($user)
            ->setEventResponse($event)
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
     * @return ParticipantResponse
     */
    public function setId(string $uuid): static
    {
        $this->uuid = $uuid;
        return $this;
    }

    /**
     * @return string
     */
    public function getRole(): string
    {
        return $this->role;
    }

    /**
     * @param string $role
     * @return ParticipantResponse
     */
    public function setRole(string $role): static
    {
        $this->role = $role;
        return $this;
    }

    /**
     * @return UserResponse
     */
    public function getUserResponse(): UserResponse
    {
        return $this->user;
    }

    /**
     * @param UserResponse $user
     * @return ParticipantResponse
     */
    public function setUserResponse(UserResponse $user): static
    {
        $this->user = $user;
        return $this;
    }

    /**
     * @return EventResponse
     */
    public function getEventResponse(): EventResponse
    {
        return $this->event;
    }

    /**
     * @param EventResponse $event
     * @return ParticipantResponse
     */
    public function setEventResponse(EventResponse $event): static
    {
        $this->event = $event;
        return $this;
    }
}