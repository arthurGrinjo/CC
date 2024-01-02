<?php

namespace App\Dto\Event;

use ApiPlatform\Doctrine\Orm\State\Options;
use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\GetCollection;
use ApiPlatform\Metadata\Link;
use App\Dto\Event\Response\EventResponse;
use App\Entity\Event as EventEntity;
use App\Provider\Provider;
use App\Validation\RegexValidations;

#[ApiResource(
    shortName: 'Event',
    output: EventResponse::class,
    provider: Provider::class,
    stateOptions: new Options(entityClass: EventEntity::class)
)]
#[GetCollection(
    uriTemplate: '/' . self::ROUTE,
    paginationItemsPerPage: 10,
    paginationClientEnabled: true,
    paginationClientItemsPerPage: true,
)]
#[Get(
    uriTemplate: '/' . self::ROUTE . '/{id}',
    uriVariables: [
        'id' => new Link(fromClass: EventEntity::class, identifiers: ['uuid']),
    ],
    requirements: [
        'uuid' => RegexValidations::REGEX_UUID
    ],
)]
class Event
{
    public const ROUTE = 'events';
}