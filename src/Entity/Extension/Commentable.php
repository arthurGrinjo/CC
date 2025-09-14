<?php

declare(strict_types=1);

namespace App\Entity\Extension;

use App\Entity\Chat;
use Doctrine\ORM\Mapping\JoinColumn;
use Doctrine\ORM\Mapping\MappedSuperclass;
use Doctrine\ORM\Mapping\OneToOne;

#[MappedSuperclass]
class Commentable
{
    #[OneToOne(targetEntity: Chat::class)]
    #[JoinColumn(name: 'chat_id', referencedColumnName: 'id')]
    private Chat|null $chat = null;

    public function getChat(): ?Chat
    {
        return $this->chat;
    }

    public function setChat(Chat $chat): void
    {
        $this->chat = $chat;
    }
}
