<?php

namespace App\Dto\Event\Response;

use ApiPlatform\Doctrine\Orm\State\Options;
use ApiPlatform\Metadata\ApiProperty;
use ApiPlatform\Metadata\ApiResource;
use App\Dto\Response;
use App\Entity\Event;
use Symfony\Component\Serializer\Attribute\SerializedName;
use Symfony\Component\Uid\Uuid;
use Symfony\Component\Validator\Constraints as Assert;

#[ApiResource(
    shortName: 'event',
    operations: [],
    stateOptions: new Options(entityClass: Event::class),
)]
final readonly class EventResponse implements Response
{
    public function __construct(
        #[SerializedName('uuid'), Assert\NotBlank]
        #[ApiProperty(identifier: true)]
        public Uuid $uuid,

        #[SerializedName('name'), Assert\NotBlank]
        public string $name,
    ) {}
}