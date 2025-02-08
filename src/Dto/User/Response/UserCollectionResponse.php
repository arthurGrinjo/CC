<?php

namespace App\Dto\User\Response;

use ApiPlatform\Metadata\ApiResource;
use App\Dto\Response;
use Symfony\Component\Serializer\Attribute\SerializedName;
use Symfony\Component\Uid\Uuid;
use Symfony\Component\Validator\Constraints as Assert;

#[ApiResource(
 operations: [],
 routePrefix: 'users',
)]
final readonly class UserCollectionResponse implements Response
{
    public function __construct(
        #[SerializedName('id'), Assert\NotBlank]
        public Uuid $uuid,

        #[SerializedName('email'), Assert\NotBlank]
        public string $email,
    ) {}
}