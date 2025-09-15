<?php

declare(strict_types=1);

namespace App\Dto\Chat;

use ApiPlatform\Doctrine\Orm\State\Options;
use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\Delete;
use ApiPlatform\Metadata\Link;
use App\Entity\Chat as ChatEntity;
use App\Processor\StandardProcessor;
use App\Validation\RegexValidations;

#[ApiResource(
    shortName: 'chat',
    stateOptions: new Options(entityClass: ChatEntity::class),
)]

#[Delete(
    uriVariables: [
        'uuid' => new Link(fromClass: ChatEntity::class, identifiers: ['uuid']),
    ],
    requirements: [
        'uuid' => RegexValidations::REGEX_UUID,
    ],
    processor: StandardProcessor::class,
)]
final readonly class Chat {}
