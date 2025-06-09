<?php

declare(strict_types=1);

namespace App\Dto\Participant;

use ApiPlatform\Doctrine\Orm\State\Options;
use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\GetCollection;
use ApiPlatform\Metadata\Link;
use App\Dto\Participant\Response\EventParticipantCollectionResponse;
use App\Dto\Participant\Response\ParticipantCollectionResponse;
use App\Dto\Participant\Response\ParticipantResponse;
use App\Entity\Event as EventEntity;
use App\Entity\Participant as ParticipantEntity;
use App\Provider\Provider;
use App\Validation\RegexValidations;

#[ApiResource(
    shortName: 'participant',
    provider: Provider::class,
    stateOptions: new Options(entityClass: ParticipantEntity::class),
)]
#[GetCollection(
    output: ParticipantCollectionResponse::class,
)]
#[Get(
    uriTemplate: '/participants/{uuid}',
    uriVariables: [
        'uuid' => new Link(fromClass: ParticipantEntity::class, identifiers: ['uuid']),
    ],
    requirements: [
        'uuid' => RegexValidations::REGEX_UUID,
    ],
    output: ParticipantResponse::class,
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
    output: EventParticipantCollectionResponse::class,
)]
final readonly class Participant {}