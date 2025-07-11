<?php

declare(strict_types=1);

namespace App\Dto\Event;

use ApiPlatform\Doctrine\Orm\State\Options;
use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\GetCollection;
use ApiPlatform\Metadata\Link;
use App\Dto\Event\Response\EventCollectionResponseDto;
use App\Dto\Event\Response\EventResponseDto;
use App\Entity\Event as EventEntity;
use App\Provider\Provider;
use App\Validation\RegexValidations;

#[ApiResource(
    shortName: 'event',
    stateOptions: new Options(entityClass: EventEntity::class),
)]
#[GetCollection(
    output: EventCollectionResponseDto::class,
    provider: Provider::class,
)]
#[Get(
    uriTemplate: '/events/{uuid}',
    uriVariables: [
        'uuid' => new Link(fromClass: EventEntity::class, identifiers: ['uuid']),
    ],
    requirements: [
        'uuid' => RegexValidations::REGEX_UUID,
    ],
    output: EventResponseDto::class,
    provider: Provider::class,
)]
final readonly class Event {}