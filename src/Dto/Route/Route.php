<?php

declare(strict_types=1);

namespace App\Dto\Route;

use ApiPlatform\Doctrine\Orm\State\Options;
use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\Delete;
use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\GetCollection;
use ApiPlatform\Metadata\Link;
use ApiPlatform\Metadata\Post;
use ApiPlatform\Metadata\Put;
use App\Dto\Route\Request\RouteRequestDto;
use App\Dto\Route\Response\RouteCollectionResponseDto;
use App\Dto\Route\Response\RouteResponseDto;
use App\Entity\Route as RouteEntity;
use App\Processor\StandardProcessor;
use App\Provider\Provider;
use App\Validation\RegexValidations;

#[ApiResource(
    shortName: 'route',
    stateOptions: new Options(entityClass: RouteEntity::class),
)]
#[GetCollection(
    output: RouteCollectionResponseDto::class,
    provider: Provider::class,
)]
#[Get(
    uriTemplate: '/routes/{uuid}',
    uriVariables: [
        'uuid' => new Link(fromClass: RouteEntity::class, identifiers: ['uuid']),
    ],
    requirements: [
        'uuid' => RegexValidations::REGEX_UUID,
    ],
    output: RouteResponseDto::class,
    provider: Provider::class,
)]
#[Post(
    input: RouteRequestDto::class,
    output: RouteResponseDto::class,
    processor: StandardProcessor::class,
)]
#[Put(
    uriVariables: [
        'uuid' => new Link(fromClass: RouteEntity::class, identifiers: ['uuid']),
    ],
    requirements: [
        'uuid' => RegexValidations::REGEX_UUID,
    ],
    input: RouteRequestDto::class,
    output: RouteResponseDto::class,
    processor: StandardProcessor::class,
)]
#[Delete(
    uriVariables: [
        'uuid' => new Link(fromClass: RouteEntity::class, identifiers: ['uuid']),
    ],
    requirements: [
        'uuid' => RegexValidations::REGEX_UUID,
    ],
    processor: StandardProcessor::class,
)]
final readonly class Route {}
