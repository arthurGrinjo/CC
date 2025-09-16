<?php

declare(strict_types=1);

namespace App\Dto\Activity\Response;

use ApiPlatform\Doctrine\Orm\State\Options;
use ApiPlatform\Metadata\ApiProperty;
use ApiPlatform\Metadata\ApiResource;
use App\Dto\Activity\Activity;
use App\Dto\Chat\Response\ChatResponseDto;
use App\Dto\ResponseDto;
use App\Entity\Activity as ActivityEntity;
use Symfony\Component\Serializer\Attribute\SerializedName;
use Symfony\Component\Uid\Uuid;
use Symfony\Component\Validator\Constraints as Assert;

#[ApiResource(
    shortName: Activity::SHORT_NAME,
    operations: [],
    stateOptions: new Options(entityClass: ActivityEntity::class),
)]
final readonly class ActivityResponseDto implements ResponseDto
{
    public function getShortName(): string
    {
        return Activity::SHORT_NAME;
    }

    public function __construct(
        #[SerializedName('uuid'), Assert\NotBlank]
        #[ApiProperty(readable: false, identifier: true)]
        public Uuid $uuid,

        #[SerializedName('name'), Assert\NotBlank]
        public string $name,

        #[SerializedName('chat')]
        #[ApiProperty(readableLink: false)]
        public ?ChatResponseDto $chat = null,
    ) {}
}
