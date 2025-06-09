<?php

declare(strict_types=1);

namespace App\Dto\User;

use ApiPlatform\Doctrine\Orm\Filter\SearchFilter;
use ApiPlatform\Doctrine\Orm\State\Options;
use ApiPlatform\Metadata\ApiFilter;
use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\GetCollection;
use ApiPlatform\Metadata\Link;
use App\Dto\User\Response\UserCollectionResponse;
use App\Dto\User\Response\UserResponse;
use App\Entity\User as UserEntity;
use App\Provider\Provider;
use App\Validation\RegexValidations;

#[ApiResource(
    shortName: 'user',
    provider: Provider::class,
    stateOptions: new Options(entityClass: UserEntity::class),
)]
#[ApiFilter(SearchFilter::class, properties: [
    'email' => 'partial',
])]
#[GetCollection(
    output: UserCollectionResponse::class,
)]
#[Get(
    uriVariables: [
        'uuid' => new Link(fromClass: UserEntity::class, identifiers: ['uuid']),
    ],
    requirements: [
        'uuid' => RegexValidations::REGEX_UUID,
    ],
    output: UserResponse::class,
)]
final readonly class User {}