<?php

declare(strict_types=1);

namespace App\Dto\Activity;

use ApiPlatform\Doctrine\Orm\State\Options;
use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\Delete;
use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\GetCollection;
use ApiPlatform\Metadata\Link;
use App\Dto\Activity\Response\ActivityCollectionResponseDto;
use App\Dto\Activity\Response\ActivityResponseDto;
use App\Entity\Activity as ActivityEntity;
use App\Processor\StandardProcessor;
use App\Provider\Provider;
use App\Validation\RegexValidations;

#[ApiResource(
    shortName: 'activity',
    stateOptions: new Options(entityClass: ActivityEntity::class),
)]
#[GetCollection(
    output: ActivityCollectionResponseDto::class,
    provider: Provider::class,
)]
#[Get(
    uriTemplate: '/activities/{uuid}',
    uriVariables: [
        'uuid' => new Link(fromClass: ActivityEntity::class, identifiers: ['uuid']),
    ],
    requirements: [
        'uuid' => RegexValidations::REGEX_UUID,
    ],
    output: ActivityResponseDto::class,
    provider: Provider::class,
)]
#[Delete(
    uriVariables: [
        'uuid' => new Link(fromClass: ActivityEntity::class, identifiers: ['uuid']),
    ],
    requirements: [
        'uuid' => RegexValidations::REGEX_UUID,
    ],
    processor: StandardProcessor::class,
)]
final readonly class Activity {}
