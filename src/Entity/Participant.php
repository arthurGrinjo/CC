<?php

declare(strict_types=1);

namespace App\Entity;

use App\Dto\Participant\Response\ParticipantResponse;
use App\Entity\Enum\ParticipantRole;
use App\Entity\Trait\IdentifiableEntity;
use App\Repository\ParticipantRepository;
use Doctrine\ORM\Mapping\Column;
use Doctrine\ORM\Mapping\Entity;
use Doctrine\ORM\Mapping\JoinColumn;
use Doctrine\ORM\Mapping\ManyToOne;
use Symfony\Component\ObjectMapper\Attribute\Map;
use Symfony\Component\Uid\Uuid;

#[Entity(repositoryClass: ParticipantRepository::class)]
#[Map(target: ParticipantResponse::class)]
class Participant implements EntityInterface
{
    use IdentifiableEntity;

    #[ManyToOne(targetEntity: User::class, cascade: ['remove'], fetch: 'EAGER')]
    #[JoinColumn(referencedColumnName: 'id', nullable: false)]
    private User $user;

    #[ManyToOne(targetEntity: Event::class, cascade: ['remove'], fetch: 'EAGER', inversedBy: 'participants')]
    #[JoinColumn(referencedColumnName: 'id', nullable: false)]
    private Event $event;

    #[Column(length: 255)]
    private ParticipantRole $role;

    public function __construct()
    {
        $this->uuid = Uuid::v6();
    }

    public function getUser(): User
    {
        return $this->user;
    }

    public function setUser(User $user): self
    {
        $this->user = $user;
        return $this;
    }

    public function getEvent(): Event
    {
        return $this->event;
    }

    public function setEvent(Event $event): self
    {
        $this->event = $event;
        return $this;
    }

    public function getRole(): ParticipantRole
    {
        return $this->role;
    }

    public function setRole(ParticipantRole $role): self
    {
        $this->role = $role;
        return $this;
    }
}
