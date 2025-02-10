<?php

namespace App\Dto\Participant;

use ApiPlatform\Doctrine\Orm\State\Options;
use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\GetCollection;
use ApiPlatform\Metadata\Link;
use App\Dto\Participant\Response\ParticipantCollectionResponse;
use App\Entity\Participant as ParticipantEntity;
use App\Provider\Provider;
use App\Validation\RegexValidations;

#[ApiResource(
    output: ParticipantCollectionResponse::class,
    provider: Provider::class,
    stateOptions: new Options(entityClass: ParticipantEntity::class)
)]
#[GetCollection(
    paginationItemsPerPage: 30,
    paginationClientEnabled: true,
    paginationClientItemsPerPage: true,
)]
#[Get(
    uriVariables: [
        'id' => new Link(fromClass: ParticipantEntity::class, identifiers: ['uuid']),
    ],
    requirements: [
        'uuid' => RegexValidations::REGEX_UUID
    ],
)]
final readonly class Participant {}