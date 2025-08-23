<?php

declare(strict_types=1);

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use App\Entity\Trait\IdentifiableEntity;
use App\Repository\GearRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping\Column;
use Doctrine\ORM\Mapping\Entity;
use Doctrine\ORM\Mapping\JoinColumn;
use Doctrine\ORM\Mapping\ManyToOne;
use Symfony\Component\Uid\Uuid;

#[ApiResource(operations: [])]
#[Entity(repositoryClass: GearRepository::class)]
class Gear implements EntityInterface
{
    use IdentifiableEntity;

    #[Column(type: Types::TEXT, length: 180)]
    private string $name;

    #[ManyToOne(targetEntity: User::class, fetch: 'EAGER')]
    #[JoinColumn(referencedColumnName: 'id', nullable: false, onDelete: 'CASCADE')]
    private User $owner;

    public function __construct()
    {
        $this->uuid = Uuid::v6();
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

    public function getOwner(): User
    {
        return $this->owner;
    }

    public function setOwner(User $owner): self
    {
        $this->owner = $owner;
        return $this;
    }
}
