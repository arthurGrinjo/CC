<?php

declare(strict_types=1);

namespace App\Dto\Comment\Response;

use ApiPlatform\Doctrine\Orm\State\Options;
use ApiPlatform\Metadata\ApiProperty;
use ApiPlatform\Metadata\ApiResource;
use App\Dto\Chat\Response\ChatResponseDto;
use App\Dto\Comment;
use App\Dto\ResponseDto;
use App\Dto\User\Response\UserResponseDto;
use App\Entity\Comment as CommentEntity;
use Symfony\Component\Serializer\Attribute\SerializedName;
use Symfony\Component\Uid\Uuid;
use Symfony\Component\Validator\Constraints as Assert;

#[ApiResource(
    shortName: Comment::SHORT_NAME,
    operations: [],
    stateOptions: new Options(entityClass: CommentEntity::class),
)]
final readonly class CommentResponseDto implements ResponseDto
{
    #[ApiProperty(readable: false)]
    public function getShortName(): string
    {
        return Comment::SHORT_NAME;
    }

    public function __construct(
        #[SerializedName('uuid'), Assert\NotBlank]
        #[ApiProperty(readable: false, identifier: true)]
        public Uuid $uuid,

        #[SerializedName('comment'), Assert\NotBlank]
        public string $comment,

        #[SerializedName('user'), Assert\NotBlank]
        #[ApiProperty(readableLink: true)]
        public UserResponseDto $user,

        #[SerializedName('chat')]
        #[ApiProperty(readableLink: false)]
        public ?ChatResponseDto $chat = null,
    ) {}
}
