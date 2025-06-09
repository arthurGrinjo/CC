<?php

declare(strict_types=1);

namespace App\Dto\Event\Response;

use ApiPlatform\Metadata\ApiProperty;
use ApiPlatform\Metadata\ApiResource;
use App\Dto\Response;
use App\Entity\Event;
use Symfony\Component\ObjectMapper\Attribute\Map;
use Symfony\Component\Serializer\Attribute\SerializedName;
use Symfony\Component\Uid\Uuid;
use Symfony\Component\Validator\Constraints as Assert;

#[ApiResource(
    shortName: 'event',
    operations: [],
)]
#[Map(source: Event::class)]
final readonly class EventResponse implements Response
{
    public function __construct(
        #[SerializedName('uuid'), Assert\NotBlank]
        #[ApiProperty(readable: false, identifier: true)]
        public Uuid $uuid,

        #[SerializedName('name'), Assert\NotBlank]
        public string $name,
    ) {}
}