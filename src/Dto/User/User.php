<?php

namespace App\Dto\User;

use ApiPlatform\Doctrine\Orm\Filter\SearchFilter;
use ApiPlatform\Doctrine\Orm\State\Options;
use ApiPlatform\Metadata\ApiFilter;
use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\GetCollection;
use ApiPlatform\Metadata\Link;
use ApiPlatform\Metadata\Post;
use App\Dto\User\Request\ResetPasswordRequest;
use App\Dto\User\Request\UserRequest;
use App\Dto\User\Response\ResetPasswordResponse;
use App\Dto\User\Response\UserCollectionResponse;
use App\Dto\User\Response\UserResponse;
use App\Entity\User as UserEntity;
use App\Processor\User\ResetPassword;
use App\Provider\Provider;
use App\Validation\RegexValidations;

#[ApiResource(
    shortName: 'user',
    input: UserRequest::class,
    provider: Provider::class,
    stateOptions: new Options(entityClass: UserEntity::class)
)]
#[ApiFilter(
    SearchFilter::class,
    properties: [
        'email' => 'partial',
    ]
)]
#[GetCollection(
    paginationItemsPerPage: 30,
    paginationClientEnabled: true,
    paginationClientItemsPerPage: true,
    output: UserCollectionResponse::class,
)]
#[Get(
    uriVariables: [
        'id' => new Link(fromClass: UserEntity::class, identifiers: ['uuid']),
    ],
    requirements: [
        'uuid' => RegexValidations::REGEX_UUID
    ],
    output: UserResponse::class,
)]
#[Post(
    output: UserResponse::class,
    processor: CreateUser::class,
)]
#[Post(
    uriTemplate: '/reset-password',
    input: ResetPasswordRequest::class,
    output: ResetPasswordResponse::class,
    processor: ResetPassword::class,
)]
final class User {
}