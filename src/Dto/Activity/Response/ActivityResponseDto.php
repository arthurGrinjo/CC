<?php

declare(strict_types=1);

namespace App\Dto\Activity\Response;

use ApiPlatform\Doctrine\Orm\State\Options;
use ApiPlatform\Metadata\ApiProperty;
use ApiPlatform\Metadata\ApiResource;
use App\Dto\Chat\Response\ChatResponseDto;
use App\Dto\ResponseDto;
use App\Entity\Activity;
use Symfony\Component\Serializer\Attribute\SerializedName;
use Symfony\Component\Uid\Uuid;
use Symfony\Component\Validator\Constraints as Assert;

#[ApiResource(
    shortName: self::SHORT_NAME,
    operations: [],
    stateOptions: new Options(entityClass: Activity::class),
)]
final readonly class ActivityResponseDto implements ResponseDto
{
    const string SHORT_NAME = 'activity';

    public function getShortName(): string
    {
        return self::SHORT_NAME;
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
