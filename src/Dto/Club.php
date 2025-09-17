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
use App\Dto\Club\Request\ClubRequestDto;
use App\Dto\Club\Response\ClubCollectionResponseDto;
use App\Dto\Club\Response\ClubResponseDto;
use App\Entity\Club as ClubEntity;
use App\Processor\StandardProcessor;
use App\Provider\Provider;
use App\Validation\RegexValidations;

#[ApiResource(
    shortName: self::SHORT_NAME,
    stateOptions: new Options(entityClass: ClubEntity::class),
)]
#[GetCollection(
    output: ClubCollectionResponseDto::class,
    provider: Provider::class,
)]
#[Get(
    uriTemplate: '/clubs/{uuid}',
    uriVariables: [
        'uuid' => new Link(fromClass: ClubEntity::class, identifiers: ['uuid']),
    ],
    requirements: [
        'uuid' => RegexValidations::REGEX_UUID,
    ],
    output: ClubResponseDto::class,
    provider: Provider::class,
)]
#[Post(
    input: ClubRequestDto::class,
    output: ClubResponseDto::class,
    processor: StandardProcessor::class,
)]
#[Put(
    uriVariables: [
        'uuid' => new Link(fromClass: ClubEntity::class, identifiers: ['uuid']),
    ],
    requirements: [
        'uuid' => RegexValidations::REGEX_UUID,
    ],
    input: ClubRequestDto::class,
    output: ClubResponseDto::class,
    processor: StandardProcessor::class,
)]
#[Delete(
    uriVariables: [
        'uuid' => new Link(fromClass: ClubEntity::class, identifiers: ['uuid']),
    ],
    requirements: [
        'uuid' => RegexValidations::REGEX_UUID,
    ],
    processor: StandardProcessor::class,
)]
final readonly class Club {
    const string SHORT_NAME = 'club';
}
