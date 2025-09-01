<?php

declare(strict_types=1);

namespace App\Dto\Gear;

use ApiPlatform\Doctrine\Orm\State\Options;
use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\GetCollection;
use ApiPlatform\Metadata\Link;
use App\Dto\Gear\Response\GearCollectionResponseDto;
use App\Dto\Gear\Response\GearResponseDto;
use App\Entity\Gear as GearEntity;
use App\Provider\Provider;
use App\Validation\RegexValidations;

#[ApiResource(
    shortName: 'gear',
    provider: Provider::class,
    stateOptions: new Options(entityClass: GearEntity::class),
)]
#[GetCollection(
    output: GearCollectionResponseDto::class,
)]
#[Get(
    uriTemplate: '/gears/{uuid}',
    uriVariables: [
        'uuid' => new Link(fromClass: GearEntity::class, identifiers: ['uuid']),
    ],
    requirements: [
        'uuid' => RegexValidations::REGEX_UUID,
    ],
    output: GearResponseDto::class,
)]
final readonly class Gear {}
