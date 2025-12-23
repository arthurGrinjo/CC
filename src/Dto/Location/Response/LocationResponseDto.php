<?php

declare(strict_types=1);

namespace App\Dto\Location\Response;

use ApiPlatform\Metadata\ApiProperty;
use App\Dto\ResponseDto;
use App\Entity\Location as LocationEntity;
use Symfony\Component\ObjectMapper\Attribute\Map;
use Symfony\Component\Serializer\Attribute\SerializedName;
use Symfony\Component\Uid\Uuid;
use Symfony\Component\Validator\Constraints as Assert;

#[Map(source: LocationEntity::class)]
final readonly class LocationResponseDto implements ResponseDto
{
    public function __construct(
        #[SerializedName('uuid'), Assert\NotBlank]
        #[ApiProperty(readable: false, identifier: true)]
        public Uuid $uuid,

        #[SerializedName('name'), Assert\NotBlank]
        public string $name,
    ) {}
}
