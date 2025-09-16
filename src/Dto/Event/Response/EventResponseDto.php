<?php

declare(strict_types=1);

namespace App\Dto\Event\Response;

use ApiPlatform\Doctrine\Orm\State\Options;
use ApiPlatform\Metadata\ApiProperty;
use ApiPlatform\Metadata\ApiResource;
use App\Dto\Event\Event;
use App\Dto\ResponseDto;
use App\Entity\Event as EventEntity;
use Symfony\Component\Serializer\Attribute\SerializedName;
use Symfony\Component\Uid\Uuid;
use Symfony\Component\Validator\Constraints as Assert;

#[ApiResource(
    shortName: Event::SHORT_NAME,
    operations: [],
    stateOptions: new Options(entityClass: EventEntity::class),
)]
final readonly class EventResponseDto implements ResponseDto
{
    public function getShortName(): string
    {
        return Event::SHORT_NAME;
    }

    public function __construct(
        #[SerializedName('uuid'), Assert\NotBlank]
        #[ApiProperty(readable: false, identifier: true)]
        public Uuid $uuid,

        #[SerializedName('name'), Assert\NotBlank]
        public string $name,
    ) {}
}
