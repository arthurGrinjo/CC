<?php

declare(strict_types=1);

namespace App\Entity;

use ApiPlatform\Metadata\ApiProperty;
use App\Entity\Enum\RelatedEntity;
use App\Entity\Trait\IdentifiableEntity;
use App\Repository\CommentRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping\Column;
use Doctrine\ORM\Mapping\Entity;
use Doctrine\ORM\Mapping\JoinColumn;
use Doctrine\ORM\Mapping\ManyToOne;
use Symfony\Component\Uid\Uuid;

#[Entity(repositoryClass: CommentRepository::class)]
class Comment implements EntityInterface
{
    use IdentifiableEntity;

    #[Column(type: Types::TEXT, length: 180)]
    private string $comment;

    #[ManyToOne(targetEntity: User::class, fetch: 'EAGER')]
    #[JoinColumn(referencedColumnName: 'id', nullable: false, onDelete: 'CASCADE')]
    private User $commenter;

    #[Column(length: 25)]
    private RelatedEntity $relatedEntity;

    #[Column(type: Types::INTEGER)]
    #[JoinColumn(referencedColumnName: 'id', nullable: false)]
    private int $relatedId;

    public function __construct()
    {
        $this->uuid = Uuid::v6();
    }

    public function getComment(): string
    {
        return $this->comment;
    }

    public function setComment(string $comment): self
    {
        $this->comment = $comment;
        return $this;
    }

    public function getCommenter(): User
    {
        return $this->commenter;
    }

    public function setCommenter(User $commenter): self
    {
        $this->commenter = $commenter;
        return $this;
    }

    public function getRelatedEntity(): RelatedEntity
    {
        return $this->relatedEntity;
    }

    public function setRelatedEntity(RelatedEntity $relatedEntity): self
    {
        $this->relatedEntity = $relatedEntity;
        return $this;
    }

    public function getRelatedId(): int
    {
        return $this->relatedId;
    }

    public function setRelatedId(int $relatedId): self
    {
        $this->relatedId = $relatedId;
        return $this;
    }
}
