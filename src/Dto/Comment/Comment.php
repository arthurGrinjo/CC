<?php

declare(strict_types=1);

namespace App\Dto\Comment;

use ApiPlatform\Doctrine\Orm\State\Options;
use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\Delete;
use ApiPlatform\Metadata\GetCollection;
use ApiPlatform\Metadata\Link;
use ApiPlatform\Metadata\Post;
use App\Dto\Comment\Request\CommentRequestDto;
use App\Dto\Comment\Response\CommentResponseDto;
use App\Entity\Activity as ActivityEntity;
use App\Entity\Article as ArticleEntity;
use App\Entity\Event as EventEntity;
use App\Entity\Comment as CommentEntity;
use App\Entity\Route as RouteEntity;
use App\Processor\StandardProcessor;
use App\Provider\CommentProvider;
use App\Provider\Provider;
use App\Validation\RegexValidations;

#[ApiResource(
    shortName: 'comment',
    stateOptions: new Options(entityClass: CommentEntity::class),
)]
#[Post(
    uriTemplate: '/comments',
    input: CommentRequestDto::class,
    output: CommentResponseDto::class,
    processor: StandardProcessor::class,
)]
#[Delete(
    uriVariables: [
        'uuid' => new Link(fromClass: CommentEntity::class, identifiers: ['uuid']),
    ],
    requirements: [
        'uuid' => RegexValidations::REGEX_UUID,
    ],
    processor: StandardProcessor::class,
)]

/** SubResource */
//#[GetCollection(
//    uriTemplate: '/activities/{uuid}/comments',
//    uriVariables: [
//        'uuid' => new Link(fromProperty: 'comments', fromClass: ActivityEntity::class, identifiers: ['uuid']),
//    ],
//    requirements: [
//        'uuid' => RegexValidations::REGEX_UUID,
//    ],
//    output: CommentResponseDto::class,
//    provider: CommentProvider::class,
//)]
//#[GetCollection(
//    uriTemplate: '/articles/{uuid}/comments',
//    uriVariables: [
//        'uuid' => new Link(fromProperty: 'comments', fromClass: ArticleEntity::class, identifiers: ['uuid']),
//    ],
//    requirements: [
//        'uuid' => RegexValidations::REGEX_UUID,
//    ],
//    output: CommentResponseDto::class,
//    provider: CommentProvider::class,
//)]
#[GetCollection(
    uriTemplate: '/events/{uuid}/comments',
    uriVariables: [
        'uuid' => new Link(fromProperty: 'comments', fromClass: EventEntity::class, identifiers: ['uuid']),
    ],
    requirements: [
        'uuid' => RegexValidations::REGEX_UUID,
    ],
    output: CommentResponseDto::class,
    provider: Provider::class,
)]
//#[GetCollection(
//    uriTemplate: '/routes/{uuid}/comments',
//    uriVariables: [
//        'uuid' => new Link(fromProperty: 'comments', fromClass: RouteEntity::class, identifiers: ['uuid']),
//    ],
//    requirements: [
//        'uuid' => RegexValidations::REGEX_UUID,
//    ],
//    output: CommentResponseDto::class,
//    provider: CommentProvider::class,
//)]
final readonly class Comment {}
