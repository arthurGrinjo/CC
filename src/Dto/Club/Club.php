<?php

declare(strict_types=1);

namespace App\Dto\Club;

use ApiPlatform\Doctrine\Orm\State\Options;
use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\GetCollection;
use ApiPlatform\Metadata\Link;
use App\Dto\Club\Response\ClubCollectionResponseDto;
use App\Dto\Club\Response\ClubResponseDto;
use App\Entity\Club as ClubEntity;
use App\Provider\Provider;
use App\Validation\RegexValidations;

#[ApiResource(
    shortName: 'club',
    provider: Provider::class,
    stateOptions: new Options(entityClass: ClubEntity::class),
)]
#[GetCollection(
    output: ClubCollectionResponseDto::class,
)]
#[Get(
    uriTemplate: '/clubs/{uuid}',
    uriVariables: [
        'uuid' => new Link(fromClass: ClubEntity::class, identifiers: ['uuid']),
    ],
    requirements: [
        'uuid' => RegexValidations::REGEX_UUID,
    ],
    output: ClubResponseDto::class,
)]
final readonly class Club {}
