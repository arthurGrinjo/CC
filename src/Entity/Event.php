<?php

declare(strict_types=1);

namespace App\Entity;

use App\Entity\Extension\Commentable;
use App\Entity\Trait\IdentifiableEntity;
use App\Repository\EventRepository;
use DateInterval;
use DateTimeImmutable;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping\Column;
use Doctrine\ORM\Mapping\Entity;
use Doctrine\ORM\Mapping\JoinColumn;
use Doctrine\ORM\Mapping\ManyToOne;
use Doctrine\ORM\Mapping\OneToMany;
use Symfony\Component\Uid\Uuid;

#[Entity(repositoryClass: EventRepository::class)]
class Event extends Commentable implements EntityInterface
{
    use IdentifiableEntity;

    #[Column(type: Types::STRING, length: 180)]
    private string $name;

    #[Column(type: Types::DATETIME_IMMUTABLE)]
    private DateTimeImmutable $startDatetime;

    #[Column(type: Types::DATETIME_IMMUTABLE)]
    private DateTimeImmutable $endDatetime;

    #[ManyToOne(targetEntity: Location::class, fetch: 'EAGER')]
    #[JoinColumn(referencedColumnName: 'id', nullable: true)]
    private ?Location $location = null;

    /** @var Collection<int, Participant> */
    #[OneToMany(targetEntity: Participant::class, mappedBy: 'event', cascade: ['persist'], fetch: 'LAZY')]
    private Collection $participants;

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

    public function getStartDatetime(): DateTimeImmutable
    {
        return $this->startDatetime;
    }

    public function setStartDatetime(DateTimeImmutable $startDatetime): self
    {
        $this->startDatetime = $startDatetime;
        return $this;
    }

    public function getEndDatetime(): DateTimeImmutable
    {
        return $this->endDatetime;
    }

    public function setEndDatetime(DateTimeImmutable $endDatetime): self
    {
        $this->endDatetime = $endDatetime;
        return $this;
    }

    public function getDuration(): DateInterval
    {
        return $this->getStartDatetime()->diff(
            $this->getEndDatetime()
        );
    }

    public function getLocation(): ?Location
    {
        return $this->location;
    }

    public function setLocation(?Location $location): self
    {
        $this->location = $location;
        return $this;
    }

    public function getNumberOfParticipants(): int
    {
        return count($this->getParticipants());
    }

    /**
     * @return Collection<int, Participant>
     */
    public function getParticipants(): Collection
    {
        return $this->participants;
    }
}
