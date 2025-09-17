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
use App\Dto\Article\Request\ArticleRequestDto;
use App\Dto\Article\Response\ArticleCollectionResponseDto;
use App\Dto\Article\Response\ArticleResponseDto;
use App\Entity\Article as ArticleEntity;
use App\Processor\StandardProcessor;
use App\Provider\Provider;
use App\Validation\RegexValidations;

#[ApiResource(
    shortName: self::SHORT_NAME,
    stateOptions: new Options(entityClass: ArticleEntity::class),
)]
#[GetCollection(
    output: ArticleCollectionResponseDto::class,
    provider: Provider::class,
)]
#[Get(
    uriTemplate: '/articles/{uuid}',
    uriVariables: [
        'uuid' => new Link(fromClass: ArticleEntity::class, identifiers: ['uuid']),
    ],
    requirements: [
        'uuid' => RegexValidations::REGEX_UUID,
    ],
    output: ArticleResponseDto::class,
    provider: Provider::class,
)]
#[Post(
    input: ArticleRequestDto::class,
    output: ArticleResponseDto::class,
    processor: StandardProcessor::class,
)]
#[Put(
    uriVariables: [
        'uuid' => new Link(fromClass: ArticleEntity::class, identifiers: ['uuid']),
    ],
    requirements: [
        'uuid' => RegexValidations::REGEX_UUID,
    ],
    input: ArticleRequestDto::class,
    output: ArticleResponseDto::class,
    processor: StandardProcessor::class,
)]
#[Delete(
    uriVariables: [
        'uuid' => new Link(fromClass: ArticleEntity::class, identifiers: ['uuid']),
    ],
    requirements: [
        'uuid' => RegexValidations::REGEX_UUID,
    ],
    processor: StandardProcessor::class,
)]
final readonly class Article {
    const string SHORT_NAME = 'article';
}
