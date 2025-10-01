<?php

declare(strict_types=1);

namespace App\Dto\Article\Request;

use App\Dto\RequestDto;
use Symfony\Component\Validator\Constraints as Assert;

class ArticleRequestDto implements RequestDto
{
    #[Assert\Length(min: 0, max: 120)]
    public string $title;
}
