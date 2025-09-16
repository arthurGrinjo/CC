<?php

declare(strict_types=1);

namespace App\Entity\Enum;

use App\Entity\Activity;
use App\Entity\Article;
use App\Entity\Event;
use App\Entity\Route;

enum CommentableEntities: string
{
    case ACTIVITY = Activity::class;
    case ARTICLE = Article::class;
    case ROUTE = Route::class;
    case EVENT = Event::class;
}
