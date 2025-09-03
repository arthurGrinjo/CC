<?php

declare(strict_types=1);

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use App\Entity\Trait\IdentifiableEntity;
use App\Repository\ClubRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping\Column;
use Doctrine\ORM\Mapping\Entity;
use Doctrine\ORM\Mapping\OneToMany;
use Symfony\Component\Uid\Uuid;

#[ApiResource(operations: [])]
#[Entity(repositoryClass: ClubRepository::class)]
class Club implements EntityInterface
{
    use IdentifiableEntity;

    #[Column(type: Types::TEXT, length: 180)]
    private string $name;

    /** @var Collection<int, Member> */
    #[OneToMany(targetEntity: Member::class, mappedBy: 'club', cascade: ['persist'], fetch: 'LAZY')]
    private Collection $members;

    public function __construct()
    {
        $this->uuid = Uuid::v6();
        $this->members = new ArrayCollection();
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
     * @return Collection<int, Member>
     */
    public function getMembers(): Collection
    {
        return $this->members;
    }
}
