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
final class Event extends Commentable implements EntityInterface
{
    use IdentifiableEntity;

    #[Column(type: Types::STRING, length: 180)]
    public string $name;

    #[Column(type: Types::DATETIME_IMMUTABLE)]
    public DateTimeImmutable $startDatetime;

    #[Column(type: Types::DATETIME_IMMUTABLE)]
    public DateTimeImmutable $endDatetime;

    #[ManyToOne(targetEntity: Location::class)]
    #[JoinColumn(referencedColumnName: 'id', nullable: true)]
    public ?Location $location;

    /** @var Collection<int, Participant> */
    #[OneToMany(targetEntity: Participant::class, mappedBy: 'event', cascade: ['persist'], fetch: 'LAZY')]
    public Collection $participants;

    public function __construct()
    {
        $this->uuid = Uuid::v6();
        $this->participants = new ArrayCollection();
    }

    public function getDuration(): DateInterval
    {
        return $this->startDatetime->diff(
            $this->endDatetime,
        );
    }

    public function getNumberOfParticipants(): int
    {
        return count($this->participants);
    }
}
