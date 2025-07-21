<?php

declare(strict_types=1);

namespace App\Dto\Participant\Request;

use ApiPlatform\Doctrine\Orm\State\Options;
use ApiPlatform\Metadata\ApiProperty;
use ApiPlatform\Metadata\ApiResource;
use App\Dto\Dto;
use App\Dto\RequestDto;
use App\Entity\Event;
use Symfony\Component\Uid\Uuid;

#[ApiResource(
    shortName: 'event',
    operations: [],
    stateOptions: new Options(entityClass: Event::class),
)]
class EventRequestDto implements RequestDto, DTO
{
    #[ApiProperty(readable: false, writable: false, identifier: true)]
    public Uuid $uuid;
}
