<?php

declare(strict_types=1);

namespace App\Dto\Gear\Response;

use ApiPlatform\Doctrine\Orm\State\Options;
use ApiPlatform\Metadata\ApiProperty;
use ApiPlatform\Metadata\ApiResource;
use App\Dto\Gear;
use App\Dto\ResponseDto;
use App\Entity\Gear as GearEntity;
use Symfony\Component\Serializer\Attribute\SerializedName;
use Symfony\Component\Uid\Uuid;
use Symfony\Component\Validator\Constraints as Assert;

#[ApiResource(
    shortName: Gear::SHORT_NAME,
    operations: [],
    stateOptions: new Options(entityClass: GearEntity::class),
)]
final readonly class GearResponseDto implements ResponseDto
{
    #[ApiProperty(readable: false)]
    public function getShortName(): string
    {
        return Gear::SHORT_NAME;
    }

    public function __construct(
        #[SerializedName('uuid'), Assert\NotBlank]
        #[ApiProperty(readable: false, identifier: true)]
        public Uuid $uuid,

        #[SerializedName('name'), Assert\NotBlank]
        public string $name,
    ) {}
}
