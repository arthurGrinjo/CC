<?php

declare(strict_types=1);

namespace App\Entity;

use App\Entity\Trait\IdentifiableEntity;
use App\Repository\ChatRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping\Column;
use Doctrine\ORM\Mapping\Entity;
use Doctrine\ORM\Mapping\OneToMany;
use Symfony\Component\Uid\Uuid;

#[Entity(repositoryClass: ChatRepository::class)]
class Chat implements EntityInterface
{
    use IdentifiableEntity;

    #[Column(type: Types::INTEGER)]
    private int $entityId;

    /** @var class-string  */
    #[Column(type: Types::STRING, length: 120)]
    private string $entity;

    /** @var Collection<int, Comment> */
    #[OneToMany(targetEntity: Comment::class, mappedBy: 'chat', cascade: ['persist'])]
    private Collection $comments;

    public function __construct()
    {
        $this->uuid = Uuid::v6();
        $this->comments = new ArrayCollection();
    }

    public function getEntityId(): int
    {
        return $this->entityId;
    }

    public function setEntityId(int $entityId): self
    {
        $this->entityId = $entityId;
        return $this;
    }

    /**
     * @return class-string
     */
    public function getEntity(): string
    {
        return $this->entity;
    }

    /**
     * @param class-string $entity
     */
    public function setEntity(string $entity): self
    {
        $this->entity = $entity;
        return $this;
    }

    /**
     * @return Collection<int, Comment>
     */
    public function getComments(): Collection
    {
        return $this->comments;
    }

    public function addComment(Comment $comment): self
    {
        if (!$this->comments->contains($comment)) {
            $this->comments[] = $comment;
        }

        return $this;
    }

    public function removeComment(Comment $comment): self
    {
        $this->comments->removeElement($comment);
        return $this;
    }
}
