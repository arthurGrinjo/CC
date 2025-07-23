<?php

declare(strict_types=1);

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use App\Entity\Trait\IdentifiableEntity;
use App\Repository\EventRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping\Column;
use Doctrine\ORM\Mapping\Entity;
use Doctrine\ORM\Mapping\OneToMany;
use Symfony\Component\Uid\Uuid;

#[ApiResource(operations: [])]
#[Entity(repositoryClass: EventRepository::class)]
class Event implements EntityInterface
{
    use IdentifiableEntity;

    #[Column(type: Types::TEXT, length: 180)]
    private string $name;

    /** @var Collection<int, Participant> */
    #[OneToMany(targetEntity: Participant::class, mappedBy: 'event', cascade: ['persist'], fetch: 'LAZY')]
    private Collection $participants;

    public function __construct()
    {
        $this->uuid = Uuid::v6();
        $this->participants = new ArrayCollection();
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
     * @return Event
     */
    public function setName(string $name): self
    {
        $this->name = $name;
        return $this;
    }

    /**
     * @return Collection<int, Participant>
     */
    public function getParticipants(): Collection
    {
        return $this->participants;
    }
}
