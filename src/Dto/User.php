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
use App\Dto\User\Request\UserRequestDto;
use App\Dto\User\Request\UserRequestPutDto;
use App\Dto\User\Response\UserCollectionResponseDto;
use App\Dto\User\Response\UserResponseDto;
use App\Entity\User as UserEntity;
use App\Processor\StandardProcessor;
use App\Provider\Provider;
use App\Validation\RegexValidations;

#[ApiResource(
    shortName: self::SHORT_NAME,
    stateOptions: new Options(entityClass: UserEntity::class),
)]
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
    processor: StandardProcessor::class,
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
    processor: StandardProcessor::class,
)]
#[Delete(
    uriVariables: [
        'uuid' => new Link(fromClass: UserEntity::class, identifiers: ['uuid']),
    ],
    requirements: [
        'uuid' => RegexValidations::REGEX_UUID,
    ],
    processor: StandardProcessor::class,
)]
final readonly class User {
    const string SHORT_NAME = 'user';
}
