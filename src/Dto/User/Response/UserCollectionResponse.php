<?php

namespace App\Dto\User\Response;

use ApiPlatform\Doctrine\Orm\State\Options;
use ApiPlatform\Metadata\ApiProperty;
use ApiPlatform\Metadata\ApiResource;
use App\Dto\Response;
use App\Entity\User;
use Symfony\Component\Serializer\Attribute\SerializedName;
use Symfony\Component\Uid\Uuid;
use Symfony\Component\Validator\Constraints as Assert;

#[ApiResource(
    shortName: 'user',
    operations: [],
    stateOptions: new Options(entityClass: User::class),
)]
final readonly class UserCollectionResponse implements Response
{
    public function __construct(
        #[SerializedName('uuid'), Assert\NotBlank]
        #[ApiProperty(identifier: true)]
        public Uuid $uuid,

        #[SerializedName('email'), Assert\NotBlank]
        public string $email,
    ) {}
}