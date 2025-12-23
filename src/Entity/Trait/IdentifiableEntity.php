<?php

declare(strict_types=1);

namespace App\Entity\Trait;

use ApiPlatform\Metadata\ApiProperty;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Uid\Uuid;

trait IdentifiableEntity
{
    #[ORM\Id, ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    #[ApiProperty(readable: false, writable: false, identifier: false)]
    public ?int $id = null;

    #[ORM\Column(type: 'uuid', unique: true)]
    #[ApiProperty(readable: false, writable: false, identifier: true)]
    public Uuid $uuid;
}

