<?php

declare(strict_types=1);

namespace App\Entity;

use App\Entity\Trait\IdentifiableEntity;
use App\Repository\MemberRepository;
use Doctrine\ORM\Mapping\Entity;
use Doctrine\ORM\Mapping\JoinColumn;
use Doctrine\ORM\Mapping\ManyToOne;
use Doctrine\ORM\Mapping\UniqueConstraint;
use Symfony\Component\Uid\Uuid;

#[Entity(repositoryClass: MemberRepository::class)]
#[UniqueConstraint(name: "member", columns: ["club_id", "user_id"])]
class Member implements EntityInterface
{
    use IdentifiableEntity;

    #[ManyToOne(targetEntity: Club::class, fetch: 'EAGER', inversedBy: 'members')]
    #[JoinColumn(referencedColumnName: 'id', nullable: false, onDelete: 'CASCADE')]
    private Club $club;

    #[ManyToOne(targetEntity: User::class, fetch: 'EAGER')]
    #[JoinColumn(referencedColumnName: 'id', nullable: false, onDelete: 'CASCADE')]
    private User $user;

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

    public function getClub(): Club
    {
        return $this->club;
    }

    public function setClub(Club $club): self
    {
        $this->club = $club;
        return $this;
    }
}
