<?php

declare(strict_types=1);

namespace App\Dto\Article\Request;

use App\Dto\RequestDto;
use App\Entity\Article;
use Symfony\Component\ObjectMapper\Attribute\Map;
use Symfony\Component\Validator\Constraints as Assert;

#[Map(target: Article::class)]
class ArticleRequestDto implements RequestDto
{
    #[Assert\Length(min: 0, max: 120)]
    public string $title;

    public string $text;
}
