<?php

declare(strict_types=1);

namespace App\Dto\Chat\Response;

use ApiPlatform\Doctrine\Orm\State\Options;
use ApiPlatform\Metadata\ApiProperty;
use ApiPlatform\Metadata\ApiResource;
use App\Dto\Chat\Chat;
use App\Dto\ResponseDto;
use App\Entity\Chat as ChatEntity;
use Symfony\Component\Serializer\Attribute\SerializedName;
use Symfony\Component\Uid\Uuid;
use Symfony\Component\Validator\Constraints as Assert;

#[ApiResource(
    shortName: Chat::SHORT_NAME,
    operations: [],
    stateOptions: new Options(entityClass: ChatEntity::class),
)]
final readonly class ChatResponseDto implements ResponseDto
{
    public function getShortName(): string
    {
        return Chat::SHORT_NAME;
    }

    public function __construct(
        #[SerializedName('uuid'), Assert\NotBlank]
        #[ApiProperty(readable: false, identifier: true)]
        public Uuid $uuid,
    ) {}
}
