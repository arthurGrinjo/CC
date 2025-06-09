<?php

declare(strict_types=1);

namespace App\Dto\User\Response;

use ApiPlatform\Metadata\ApiProperty;
use ApiPlatform\Metadata\ApiResource;
use App\Dto\Response;
use App\Entity\User;
use Symfony\Component\ObjectMapper\Attribute\Map;
use Symfony\Component\Serializer\Attribute\SerializedName;
use Symfony\Component\Uid\Uuid;
use Symfony\Component\Validator\Constraints as Assert;

#[ApiResource(
    shortName: 'user',
    operations: [],
)]
#[Map(source: User::class)]
class UserResponse implements Response
{
    public function __construct(
        #[SerializedName('uuid'), Assert\NotBlank]
        #[ApiProperty(readable: false, identifier: true, genId: false)]
        public Uuid $uuid,

        #[SerializedName('email'), Assert\NotBlank]
        public string $email,

        #[SerializedName('first_name'), Assert\NotBlank]
        public string $firstName,

        #[SerializedName('last_name'), Assert\NotBlank]
        public string $lastName,
    ) {}
}