<?php

declare(strict_types=1);

namespace App\Dto\Participant;

use ApiPlatform\Doctrine\Orm\Filter\SearchFilter;
use ApiPlatform\Doctrine\Orm\State\Options;
use ApiPlatform\Metadata\ApiFilter;
use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\Delete;
use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\GetCollection;
use ApiPlatform\Metadata\Link;
use ApiPlatform\Metadata\Post;
use App\Dto\Participant\Request\ParticipantRequestDto;
use App\Dto\Participant\Response\EventParticipantCollectionResponseDto;
use App\Dto\Participant\Response\ParticipantCollectionResponseDto;
use App\Dto\Participant\Response\ParticipantResponseDto;
use App\Entity\Event as EventEntity;
use App\Entity\Participant as ParticipantEntity;
use App\Processor\StandardProcessor;
use App\Provider\Provider;
use App\Validation\RegexValidations;

#[ApiResource(
    shortName: 'participant',
    stateOptions: new Options(entityClass: ParticipantEntity::class),
)]
#[ApiFilter(SearchFilter::class, properties: [
    'event.name' => 'partial',
])]
#[GetCollection(
    output: ParticipantCollectionResponseDto::class,
    provider: Provider::class,
)]
#[Get(
    uriTemplate: '/participants/{uuid}',
    uriVariables: [
        'uuid' => new Link(fromClass: ParticipantEntity::class, identifiers: ['uuid']),
    ],
    requirements: [
        'uuid' => RegexValidations::REGEX_UUID,
    ],
    output: ParticipantResponseDto::class,
    provider: Provider::class,
)]
#[Post(
    uriTemplate: '/participants',
    input: ParticipantRequestDto::class,
    output: ParticipantResponseDto::class,
    processor: StandardProcessor::class,
)]
#[Delete(
    uriVariables: [
        'uuid' => new Link(fromClass: ParticipantEntity::class, identifiers: ['uuid']),
    ],
    requirements: [
        'uuid' => RegexValidations::REGEX_UUID,
    ],
    processor: StandardProcessor::class,
)]

/** SubResource */
#[GetCollection(
    uriTemplate: '/events/{uuid}/participants',
    uriVariables: [
        'uuid' => new Link(fromProperty: 'participants', fromClass: EventEntity::class, identifiers: ['uuid']),
    ],
    requirements: [
        'uuid' => RegexValidations::REGEX_UUID,
    ],
    output: EventParticipantCollectionResponseDto::class,
    provider: Provider::class,
)]
final readonly class Participant {}
