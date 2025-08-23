<?php

declare(strict_types=1);

namespace App\Dto\Route;

use ApiPlatform\Doctrine\Orm\State\Options;
use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\GetCollection;
use ApiPlatform\Metadata\Link;
use App\Dto\Route\Response\RouteCollectionResponseDto;
use App\Dto\Route\Response\RouteResponseDto;
use App\Entity\Route as RouteEntity;
use App\Provider\Provider;
use App\Validation\RegexValidations;

#[ApiResource(
    shortName: 'route',
    provider: Provider::class,
    stateOptions: new Options(entityClass: RouteEntity::class),
)]
#[GetCollection(
    output: RouteCollectionResponseDto::class,
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
)]
final readonly class Route {}
