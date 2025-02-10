<?php

namespace App\Dto\User;

use ApiPlatform\Doctrine\Orm\State\Options;
use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\Delete;
use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\GetCollection;
use ApiPlatform\Metadata\Link;
use ApiPlatform\Metadata\Post;
use App\Dto\User\Response\UserCollectionResponse;
use App\Dto\User\Response\UserResponse;
use App\Entity\User as UserEntity;
use App\Provider\Provider;
use App\Validation\RegexValidations;

#[ApiResource(
    shortName: 'user',
    paginationClientEnabled: true,
    paginationClientItemsPerPage: true,
    paginationItemsPerPage: 5,
    provider: Provider::class,
    stateOptions: new Options(entityClass: UserEntity::class),
)]
#[GetCollection(
    output: UserCollectionResponse::class,
)]
#[Get(
    uriTemplate: '/users/{uuid}',
    uriVariables: [
        'uuid' => new Link(fromClass: UserEntity::class, identifiers: ['uuid']),
    ],
    requirements: [
        'uuid' => RegexValidations::REGEX_UUID,
    ],
    output: UserResponse::class,
)]
#[Post]
#[Delete(
    uriVariables: [
        'uuid' => new Link(fromClass: UserEntity::class, identifiers: ['uuid']),
    ],
    requirements: [
        'uuid' => RegexValidations::REGEX_UUID,
    ],
)]
final readonly class User {}