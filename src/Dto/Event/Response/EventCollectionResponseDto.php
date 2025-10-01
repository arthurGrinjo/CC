<?php

declare(strict_types=1);

namespace App\Dto\Event\Response;

use ApiPlatform\Doctrine\Orm\State\Options;
use ApiPlatform\Metadata\ApiProperty;
use ApiPlatform\Metadata\ApiResource;
use App\Dto\Event;
use App\Dto\Location\Response\LocationResponseDto;
use App\Dto\ResponseDto;
use App\Entity\Event as EventEntity;
use DateInterval;
use DateTimeImmutable;
use Symfony\Component\Serializer\Attribute\Context;
use Symfony\Component\Serializer\Attribute\SerializedName;
use Symfony\Component\Serializer\Normalizer\DateIntervalNormalizer;
use Symfony\Component\Serializer\Normalizer\DateTimeNormalizer;
use Symfony\Component\Uid\Uuid;
use Symfony\Component\Validator\Constraints as Assert;

#[ApiResource(
    shortName: Event::SHORT_NAME,
    operations: [],
    stateOptions: new Options(entityClass: EventEntity::class),
)]
final readonly class EventCollectionResponseDto implements ResponseDto
{
    #[ApiProperty(readable: false)]
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

        #[Context(
            normalizationContext: [DateTimeNormalizer::FORMAT_KEY => 'Y-m-d H:i:s'],
        )]
        public DateTimeImmutable $startDatetime,

        #[Context(
            normalizationContext: [DateTimeNormalizer::FORMAT_KEY => 'Y-m-d H:i:s'],
        )]
        public DateTimeImmutable $endDatetime,

        #[SerializedName('location')]
        #[ApiProperty(readableLink: false)]
        public ?LocationResponseDto $location = null,
    ) {}
}
