<?php

declare(strict_types=1);

namespace App\Dto\Member;

use ApiPlatform\Doctrine\Orm\Filter\SearchFilter;
use ApiPlatform\Doctrine\Orm\State\Options;
use ApiPlatform\Metadata\ApiFilter;
use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\Delete;
use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\GetCollection;
use ApiPlatform\Metadata\Link;
use App\Dto\Member\Response\ClubMemberCollectionResponseDto;
use App\Dto\Member\Response\MemberCollectionResponseDto;
use App\Dto\Member\Response\MemberResponseDto;
use App\Entity\Club as ClubEntity;
use App\Entity\Member as MemberEntity;
use App\Processor\StandardProcessor;
use App\Provider\Provider;
use App\Validation\RegexValidations;

#[ApiResource(
    shortName: 'member',
    stateOptions: new Options(entityClass: MemberEntity::class),
)]
#[ApiFilter(SearchFilter::class, properties: [
    'club.name' => 'partial',
])]
#[GetCollection(
    output: MemberCollectionResponseDto::class,
    provider: Provider::class,
)]
#[Get(
    uriTemplate: '/members/{uuid}',
    uriVariables: [
        'uuid' => new Link(fromClass: MemberEntity::class, identifiers: ['uuid']),
    ],
    requirements: [
        'uuid' => RegexValidations::REGEX_UUID,
    ],
    output: MemberResponseDto::class,
    provider: Provider::class,
)]
#[Delete(
    uriVariables: [
        'uuid' => new Link(fromClass: MemberEntity::class, identifiers: ['uuid']),
    ],
    requirements: [
        'uuid' => RegexValidations::REGEX_UUID,
    ],
    processor: StandardProcessor::class,
)]

/** SubResource */
#[GetCollection(
    uriTemplate: '/clubs/{uuid}/members',
    uriVariables: [
        'uuid' => new Link(fromProperty: 'members', fromClass: ClubEntity::class, identifiers: ['uuid']),
    ],
    requirements: [
        'uuid' => RegexValidations::REGEX_UUID,
    ],
    output: ClubMemberCollectionResponseDto::class,
    provider: Provider::class,
)]
final readonly class Member {}
