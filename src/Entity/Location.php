<?php

declare(strict_types=1);

namespace App\Entity;

use App\Dto\Location\Request\LocationRequestDto;
use App\Dto\Location\Response\LocationResponseDto;
use App\Entity\Trait\IdentifiableEntity;
use App\Repository\LocationRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping\Column;
use Doctrine\ORM\Mapping\Entity;
use Symfony\Component\ObjectMapper\Attribute\Map;
use Symfony\Component\Uid\Uuid;

#[Entity(repositoryClass: LocationRepository::class)]
#[Map(target: LocationResponseDto::class )]
class Location implements EntityInterface
{
    use IdentifiableEntity;

    #[Column(type: Types::STRING, length: 180)]
    public string $name;

    public function __construct()
    {
        $this->uuid = Uuid::v6();
    }
}
