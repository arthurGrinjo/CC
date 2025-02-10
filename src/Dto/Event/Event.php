<?php

namespace App\Dto\Event;

use ApiPlatform\Doctrine\Orm\State\Options;
use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\GetCollection;
use ApiPlatform\Metadata\Link;
use App\Dto\Event\Response\EventCollectionResponse;
use App\Entity\Event as EventEntity;
use App\Provider\Provider;
use App\Validation\RegexValidations;

#[ApiResource(
    output: EventCollectionResponse::class,
    provider: Provider::class,
    stateOptions: new Options(entityClass: EventEntity::class)
)]
#[GetCollection(
    paginationItemsPerPage: 10,
    paginationClientEnabled: true,
    paginationClientItemsPerPage: true,
)]
#[Get(
    uriVariables: [
        'id' => new Link(fromClass: EventEntity::class, identifiers: ['uuid']),
    ],
    requirements: [
        'uuid' => RegexValidations::REGEX_UUID
    ],
)]
final readonly class Event {}