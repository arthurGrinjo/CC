<?php

declare(strict_types=1);

namespace App\Entity;

use App\Entity\Extension\Commentable;
use App\Entity\Trait\IdentifiableEntity;
use App\Repository\EventRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping\Column;
use Doctrine\ORM\Mapping\Entity;
use Doctrine\ORM\Mapping\OneToMany;
use Symfony\Component\Uid\Uuid;

#[Entity(repositoryClass: EventRepository::class)]
class Event extends Commentable implements EntityInterface
{
    use IdentifiableEntity;

    #[Column(type: Types::STRING, length: 180)]
    private string $name;

    /** @var Collection<int, Participant> */
    #[OneToMany(targetEntity: Participant::class, mappedBy: 'event', cascade: ['persist'], fetch: 'LAZY')]
    private Collection $participants;

    /** @var Collection<int, Comment> */
    #[OneToMany(targetEntity: Comment::class, mappedBy: 'event', cascade: ['persist'], fetch: 'LAZY')]
    private Collection $comments;

    public function __construct()
    {
        $this->uuid = Uuid::v6();
        $this->participants = new ArrayCollection();
    }

    public function getName(): string
    {
        return $this->name;
    }

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
