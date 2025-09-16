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
use App\Entity\Chat as ChatEntity;
use App\Entity\Comment as CommentEntity;
use App\Processor\Comment\Processor as CommentProcessor;
use App\Processor\StandardProcessor;
use App\Provider\Provider;
use App\Validation\RegexValidations;

#[ApiResource(
    shortName: 'comment',
    stateOptions: new Options(entityClass: CommentEntity::class),
)]
#[GetCollection(
    uriTemplate: '/chats/{uuid}/comments',
    uriVariables: [
        'uuid' => new Link(fromProperty: 'comments', fromClass: ChatEntity::class, identifiers: ['uuid']),
    ],
    requirements: [
        'uuid' => RegexValidations::REGEX_UUID,
    ],
    output: CommentResponseDto::class,
    provider: Provider::class,
)]

/** todo: Create CommentProvider to convert entity to Chat-entity */
//#[GetCollection(
//    uriTemplate: '/activities/{uuid}/comments',
//    uriVariables: [
//        'uuid' => new Link(fromProperty: 'comments', fromClass: ActivityEntity::class, identifiers: ['uuid']),
//    ],
//    requirements: [
//        'uuid' => RegexValidations::REGEX_UUID,
//    ],
//    output: CommentResponseDto::class,
//    provider: Provider::class,
//)]

#[Post(
    uriTemplate: '/comments',
    input: CommentRequestDto::class,
    output: CommentResponseDto::class,
    processor: CommentProcessor::class,
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
final readonly class Comment {}
