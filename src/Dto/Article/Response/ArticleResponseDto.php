<?php

declare(strict_types=1);

namespace App\Dto\Article\Response;

use ApiPlatform\Doctrine\Orm\State\Options;
use ApiPlatform\Metadata\ApiProperty;
use ApiPlatform\Metadata\ApiResource;
use App\Dto\Article\Article;
use App\Dto\ResponseDto;
use App\Entity\Article as ArticleEntity;
use Symfony\Component\Serializer\Attribute\SerializedName;
use Symfony\Component\Uid\Uuid;
use Symfony\Component\Validator\Constraints as Assert;

#[ApiResource(
    shortName: Article::SHORT_NAME,
    operations: [],
    stateOptions: new Options(entityClass: ArticleEntity::class),
)]
final readonly class ArticleResponseDto implements ResponseDto
{
    public function getShortName(): string
    {
        return Article::SHORT_NAME;
    }

    public function __construct(
        #[SerializedName('uuid'), Assert\NotBlank]
        #[ApiProperty(readable: false, identifier: true)]
        public Uuid $uuid,

        #[SerializedName('name'), Assert\NotBlank]
        public string $name,
    ) {}
}
