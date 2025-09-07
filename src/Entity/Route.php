<?php

declare(strict_types=1);

namespace App\Entity;

use App\Entity\Trait\IdentifiableEntity;
use App\Repository\RouteRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping\Column;
use Doctrine\ORM\Mapping\Entity;
use Symfony\Component\Uid\Uuid;

#[Entity(repositoryClass: RouteRepository::class)]
class Route implements EntityInterface
{
    use IdentifiableEntity;

    #[Column(type: Types::STRING, length: 180)]
    private string $name;

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
}
