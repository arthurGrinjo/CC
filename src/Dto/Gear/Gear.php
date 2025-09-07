<?php

declare(strict_types=1);

namespace App\Dto\Gear;

use ApiPlatform\Doctrine\Orm\State\Options;
use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\Delete;
use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\Link;
use ApiPlatform\Metadata\Post;
use App\Dto\Gear\Request\GearRequestDto;
use App\Dto\Gear\Response\GearResponseDto;
use App\Entity\Gear as GearEntity;
use App\Processor\StandardProcessor;
use App\Provider\Provider;
use App\Validation\RegexValidations;

#[ApiResource(
    shortName: 'gear',
    stateOptions: new Options(entityClass: GearEntity::class),
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
    provider: Provider::class,
)]
#[Post(
    input: GearRequestDto::class,
    output: GearResponseDto::class,
    processor: StandardProcessor::class,
)]
#[Delete(
    uriVariables: [
        'uuid' => new Link(fromClass: GearEntity::class, identifiers: ['uuid']),
    ],
    requirements: [
        'uuid' => RegexValidations::REGEX_UUID,
    ],
    processor: StandardProcessor::class,
)]
final readonly class Gear {}
