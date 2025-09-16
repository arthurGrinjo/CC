<?php

declare(strict_types=1);

namespace App\Dto\Member\Response;

use ApiPlatform\Doctrine\Orm\State\Options;
use ApiPlatform\Metadata\ApiProperty;
use ApiPlatform\Metadata\ApiResource;
use App\Dto\Club\Response\ClubResponseDto;
use App\Dto\Member\Member;
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
final readonly class MemberCollectionResponseDto implements ResponseDto
{
    public function getShortName(): string
    {
        return Member::SHORT_NAME;
    }

    public function __construct(
        #[SerializedName('uuid'), Assert\NotBlank]
        #[ApiProperty(readable: false, identifier: true)]
        public Uuid             $uuid,

        #[SerializedName('user'), Assert\NotBlank]
        #[ApiProperty(readableLink: true)]
        public UserResponseDto $user,

        #[SerializedName('club'), Assert\NotBlank]
        #[ApiProperty(readableLink: true)]
        public ClubResponseDto $club,
    ) {}
}
