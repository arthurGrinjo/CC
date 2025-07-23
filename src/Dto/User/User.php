<?php

declare(strict_types=1);

namespace App\Dto\User;

use ApiPlatform\Doctrine\Orm\Filter\SearchFilter;
use ApiPlatform\Doctrine\Orm\State\Options;
use ApiPlatform\Metadata\ApiFilter;
use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\Delete;
use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\GetCollection;
use ApiPlatform\Metadata\Link;
use ApiPlatform\Metadata\Post;
use ApiPlatform\Metadata\Put;
use App\Controller\Dto\User\Request\UserRequestDto;
use App\Controller\Dto\User\Request\UserRequestPutDto;
use App\Controller\Dto\User\Response\UserCollectionResponseDto;
use App\Controller\Dto\User\Response\UserResponseDto;
use App\Entity\User as UserEntity;
use App\Processor;
use App\Processor\User\UpdateUser;
use App\Provider\Provider;
use App\Validation\RegexValidations;

#[ApiResource(
    shortName: 'user',
    stateOptions: new Options(entityClass: UserEntity::class),
)]
#[ApiFilter(SearchFilter::class, properties: [
    'email' => 'partial',
])]
#[GetCollection(
    output: UserCollectionResponseDto::class,
    provider: Provider::class,
)]
#[Get(
    uriTemplate: '/users/{uuid}',
    uriVariables: [
        'uuid' => new Link(fromClass: UserEntity::class, identifiers: ['uuid']),
    ],
    requirements: [
        'uuid' => RegexValidations::REGEX_UUID,
    ],
    output: UserResponseDto::class,
    provider: Provider::class,
)]
#[Post(
    input: UserRequestDto::class,
    output: UserResponseDto::class,
    processor: Processor\Create::class,
)]
#[Put(
    uriVariables: [
        'uuid' => new Link(fromClass: UserEntity::class, identifiers: ['uuid']),
    ],
    requirements: [
        'uuid' => RegexValidations::REGEX_UUID,
    ],
    input: UserRequestPutDto::class,
    output: UserResponseDto::class,
    processor: Processor\Update::class,
)]
#[Delete(
    uriVariables: [
        'uuid' => new Link(fromClass: UserEntity::class, identifiers: ['uuid']),
    ],
    requirements: [
        'uuid' => RegexValidations::REGEX_UUID,
    ],
    processor: Processor\Delete::class,
)]
final readonly class User {}
