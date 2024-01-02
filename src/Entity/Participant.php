<?php

namespace App\Entity;

use App\Entity\Enum\ParticipantRole;
use App\Entity\Trait\IdentifiableEntity;
use App\Repository\ParticipantRepository;
use Doctrine\ORM\Mapping\Column;
use Doctrine\ORM\Mapping\Entity;
use Doctrine\ORM\Mapping\JoinColumn;
use Doctrine\ORM\Mapping\ManyToOne;
use Symfony\Component\Uid\Uuid;

#[Entity(repositoryClass: ParticipantRepository::class)]
class Participant implements EntityInterface
{
    use IdentifiableEntity;

    #[ManyToOne(targetEntity: User::class, cascade: ['remove'])]
    #[JoinColumn(referencedColumnName: 'id', nullable: false)]
    private ?User $User = null;

    #[ManyToOne(targetEntity: Event::class, cascade: ['remove'], inversedBy: 'participants')]
    #[JoinColumn(referencedColumnName: 'id', nullable: false)]
    private ?Event $Event = null;

    #[Column(length: 255)]
    private ?ParticipantRole $role = null;

    public function __construct()
    {
        $this->uuid = Uuid::v6();
    }

    public function getUser(): ?User
    {
        return $this->User;
    }

    public function setUser(?User $User): static
    {
        $this->User = $User;

        return $this;
    }

    public function getEvent(): ?Event
    {
        return $this->Event;
    }

    public function setEvent(?Event $Event): static
    {
        $this->Event = $Event;

        return $this;
    }

    public function getRole(): ?ParticipantRole
    {
        return $this->role;
    }

    public function setRole(?ParticipantRole $role): Participant
    {
        $this->role = $role;
        return $this;
    }
}
