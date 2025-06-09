<?php

namespace App\Dto\Event;

use ApiPlatform\Doctrine\Orm\State\Options;
use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\Delete;
use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\GetCollection;
use ApiPlatform\Metadata\Link;
use ApiPlatform\Metadata\Post;
use App\Dto\Event\Response\EventCollectionResponse;
use App\Dto\Event\Response\EventResponse;
use App\Entity\Event as EventEntity;
use App\Provider\Provider;
use App\Validation\RegexValidations;

#[ApiResource(
    shortName: 'event',
    provider: Provider::class,
    stateOptions: new Options(entityClass: EventEntity::class),
)]
#[GetCollection(
    output: EventCollectionResponse::class,
)]
#[Get(
    uriTemplate: '/events/{uuid}',
    uriVariables: [
        'uuid' => new Link(fromClass: EventEntity::class, identifiers: ['uuid']),
    ],
    requirements: [
        'uuid' => RegexValidations::REGEX_UUID,
    ],
    output: EventResponse::class,
)]
final readonly class Event {}