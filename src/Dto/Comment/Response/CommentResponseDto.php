<?php

declare(strict_types=1);

namespace App\Dto\Comment\Response;

use ApiPlatform\Doctrine\Orm\State\Options;
use ApiPlatform\Metadata\ApiProperty;
use ApiPlatform\Metadata\ApiResource;
use App\Dto\ResponseDto;
use App\Entity\Comment;
use App\Entity\Enum\RelatedEntity;
use App\Entity\Event;
use Symfony\Component\Serializer\Attribute\SerializedName;
use Symfony\Component\Uid\Uuid;
use Symfony\Component\Validator\Constraints as Assert;

#[ApiResource(
    shortName: 'comment',
    operations: [],
    stateOptions: new Options(Comment::class),
)]
final readonly class CommentResponseDto implements ResponseDto
{
    public function __construct(
        #[SerializedName('uuid'), Assert\NotBlank]
        #[ApiProperty(readable: false, identifier: true)]
        public Uuid $uuid,

        #[SerializedName('comment'), Assert\NotBlank]
        public string $comment,

        #[SerializedName('commenter'), Assert\NotBlank]
        #[ApiProperty(readableLink: true)]
        public UserResponseDto $commenter,

//        #[SerializedName('relatedEntity'), Assert\NotBlank]
//        public RelatedEntity $relatedEntity,
//
//        #[SerializedName('related'), Assert\NotBlank]
//        public Event $related,
    ) {}
}
