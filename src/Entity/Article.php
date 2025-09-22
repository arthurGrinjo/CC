<?php

declare(strict_types=1);

namespace App\Entity;

use App\Entity\Extension\Commentable;
use App\Entity\Trait\IdentifiableEntity;
use App\Repository\ArticleRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping\Column;
use Doctrine\ORM\Mapping\Entity;
use Doctrine\ORM\Mapping\OneToMany;
use Symfony\Component\Uid\Uuid;

#[Entity(repositoryClass: ArticleRepository::class)]
class Article extends Commentable implements EntityInterface
{
    use IdentifiableEntity;

    #[Column(type: Types::STRING, length: 180)]
    private string $title;

    #[Column(type: Types::TEXT)]
    private string $text;

    public function __construct()
    {
        $this->uuid = Uuid::v6();
    }

    public function getTitle(): string
    {
        return $this->title;
    }

    public function setTitle(string $title): self
    {
        $this->title = $title;
        return $this;
    }

    public function getText(): string
    {
        return $this->text;
    }

    public function setText(string $text): self
    {
        $this->text = $text;
        return $this;
    }
}
