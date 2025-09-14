<?php

declare(strict_types=1);

namespace App\Entity;

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

    #[ManyToOne(targetEntity: Chat::class, fetch: 'EAGER', inversedBy: 'comments')]
    #[JoinColumn(referencedColumnName: 'id', nullable: false, onDelete: 'CASCADE')]
    private Chat $chat;

    #[ManyToOne(targetEntity: User::class, fetch: 'EAGER')]
    #[JoinColumn(referencedColumnName: 'id', nullable: false, onDelete: 'CASCADE')]
    private User $user;

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

    public function getChat(): Chat
    {
        return $this->chat;
    }

    public function setChat(Chat $chat): self
    {
        $this->chat = $chat;
        return $this;
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
}
