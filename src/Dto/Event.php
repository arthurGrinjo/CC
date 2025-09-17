<?php

declare(strict_types=1);

namespace App\Dto;

use ApiPlatform\Doctrine\Orm\State\Options;
use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\Delete;
use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\GetCollection;
use ApiPlatform\Metadata\Link;
use ApiPlatform\Metadata\Post;
use ApiPlatform\Metadata\Put;
use App\Dto\Event\Request\EventRequestDto;
use App\Dto\Event\Response\EventCollectionResponseDto;
use App\Dto\Event\Response\EventResponseDto;
use App\Entity\Event as EventEntity;
use App\Processor\StandardProcessor;
use App\Provider\Provider;
use App\Validation\RegexValidations;

#[ApiResource(
shortName: self::SHORT_NAME,
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
#[Post(
    input: EventRequestDto::class,
    output: EventResponseDto::class,
    processor: StandardProcessor::class,
)]
#[Put(
    uriVariables: [
        'uuid' => new Link(fromClass: EventEntity::class, identifiers: ['uuid']),
    ],
    requirements: [
        'uuid' => RegexValidations::REGEX_UUID,
    ],
    input: EventRequestDto::class,
    output: EventResponseDto::class,
    processor: StandardProcessor::class,
)]
#[Delete(
    uriVariables: [
        'uuid' => new Link(fromClass: EventEntity::class, identifiers: ['uuid']),
    ],
    requirements: [
        'uuid' => RegexValidations::REGEX_UUID,
    ],
    processor: StandardProcessor::class,
)]
final readonly class Event {
    const string SHORT_NAME = 'event';
}
