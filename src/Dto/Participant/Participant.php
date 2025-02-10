<?php

namespace App\Dto\Participant;

use ApiPlatform\Doctrine\Orm\State\Options;
use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\Delete;
use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\GetCollection;
use ApiPlatform\Metadata\Link;
use ApiPlatform\Metadata\Post;
use App\Dto\Participant\Response\ParticipantCollectionResponse;
use App\Dto\Participant\Response\ParticipantResponse;
use App\Entity\Participant as ParticipantEntity;
use App\Provider\Provider;
use App\Validation\RegexValidations;

#[ApiResource(
    shortName: 'participant',
    paginationClientEnabled: true,
    paginationClientItemsPerPage: true,
    paginationItemsPerPage: 5,
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
#[Post]
#[Delete(
    uriVariables: [
        'uuid' => new Link(fromClass: ParticipantEntity::class, identifiers: ['uuid']),
    ],
    requirements: [
        'uuid' => RegexValidations::REGEX_UUID,
    ],
)]
final readonly class Participant {}