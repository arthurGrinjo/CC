<?php

declare(strict_types=1);

namespace App\Dto\User\Response;

use ApiPlatform\Doctrine\Orm\State\Options;
use ApiPlatform\Metadata\ApiProperty;
use ApiPlatform\Metadata\ApiResource;
use App\Dto\ResponseDto;
use App\Dto\User\User;
use App\Entity\User as UserEntity;
use Symfony\Component\Serializer\Attribute\SerializedName;
use Symfony\Component\Uid\Uuid;
use Symfony\Component\Validator\Constraints as Assert;

#[ApiResource(
    shortName: User::SHORT_NAME,
    operations: [],
    stateOptions: new Options(UserEntity::class),
)]
final readonly class UserCollectionResponseDto implements ResponseDto
{
    public function getShortName(): string
    {
        return User::SHORT_NAME;
    }

    public function __construct(
        #[SerializedName('uuid'), Assert\NotBlank]
        #[ApiProperty(readable: false, identifier: true)]
        public Uuid $uuid,

        #[SerializedName('email'), Assert\NotBlank]
        public string $email,
    ) {}
}
