<?php

declare(strict_types=1);

namespace App\Dto\Club\Response;

use ApiPlatform\Doctrine\Orm\State\Options;
use ApiPlatform\Metadata\ApiProperty;
use ApiPlatform\Metadata\ApiResource;
use App\Dto\Club\Club;
use App\Dto\ResponseDto;
use App\Entity\Club as ClubEntity;
use Symfony\Component\Serializer\Attribute\SerializedName;
use Symfony\Component\Uid\Uuid;
use Symfony\Component\Validator\Constraints as Assert;

#[ApiResource(
    shortName: Club::SHORT_NAME,
    operations: [],
    stateOptions: new Options(entityClass: ClubEntity::class),
)]
final readonly class ClubResponseDto implements ResponseDto
{
    public function getShortName(): string
    {
        return Club::SHORT_NAME;
    }

    public function __construct(
        #[SerializedName('uuid'), Assert\NotBlank]
        #[ApiProperty(readable: false, identifier: true)]
        public Uuid $uuid,

        #[SerializedName('name'), Assert\NotBlank]
        public string $name,
    ) {}
}
