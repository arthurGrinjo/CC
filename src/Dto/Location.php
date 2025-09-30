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
use App\Dto\Location\Request\LocationRequestDto;
use App\Dto\Location\Response\LocationCollectionResponseDto;
use App\Dto\Location\Response\LocationResponseDto;
use App\Entity\Location as LocationEntity;
use App\Processor\StandardProcessor;
use App\Provider\Provider;
use App\Validation\RegexValidations;

#[ApiResource(
    shortName: self::SHORT_NAME,
    stateOptions: new Options(entityClass: LocationEntity::class),
)]
#[GetCollection(
    output: LocationCollectionResponseDto::class,
    provider: Provider::class,
)]
#[Get(
    uriTemplate: '/locations/{uuid}',
    uriVariables: [
        'uuid' => new Link(fromClass: LocationEntity::class, identifiers: ['uuid']),
    ],
    requirements: [
        'uuid' => RegexValidations::REGEX_UUID,
    ],
    output: LocationResponseDto::class,
    provider: Provider::class,
)]
#[Post(
    input: LocationRequestDto::class,
    output: LocationResponseDto::class,
    processor: StandardProcessor::class,
)]
#[Put(
    uriVariables: [
        'uuid' => new Link(fromClass: LocationEntity::class, identifiers: ['uuid']),
    ],
    requirements: [
        'uuid' => RegexValidations::REGEX_UUID,
    ],
    input: LocationRequestDto::class,
    output: LocationResponseDto::class,
    processor: StandardProcessor::class,
)]
#[Delete(
    uriVariables: [
        'uuid' => new Link(fromClass: LocationEntity::class, identifiers: ['uuid']),
    ],
    requirements: [
        'uuid' => RegexValidations::REGEX_UUID,
    ],
    processor: StandardProcessor::class,
)]
final readonly class Location {
    const string SHORT_NAME = 'location';
}
