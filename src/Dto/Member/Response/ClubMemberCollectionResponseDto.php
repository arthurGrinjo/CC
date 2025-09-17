<?php

declare(strict_types=1);

namespace App\Dto\Member\Response;

use ApiPlatform\Doctrine\Orm\State\Options;
use ApiPlatform\Metadata\ApiProperty;
use ApiPlatform\Metadata\ApiResource;
use App\Dto\Member;
use App\Dto\ResponseDto;
use App\Dto\User\Response\UserResponseDto;
use App\Entity\Member as MemberEntity;
use Symfony\Component\Serializer\Attribute\SerializedName;
use Symfony\Component\Uid\Uuid;
use Symfony\Component\Validator\Constraints as Assert;

#[ApiResource(
    shortName: Member::SHORT_NAME,
    operations: [],
    stateOptions: new Options(MemberEntity::class),
)]
final readonly class ClubMemberCollectionResponseDto implements ResponseDto
{
    #[ApiProperty(readable: false)]
    public function getShortName(): string
    {
        return Member::SHORT_NAME;
    }

    public function __construct(
        #[SerializedName('uuid'), Assert\NotBlank]
        #[ApiProperty(readable: false, identifier: true)]
        public Uuid $uuid,

        #[SerializedName('user'), Assert\NotBlank]
        #[ApiProperty(readableLink: true)]
        public UserResponseDto $user,
    ) {}
}
