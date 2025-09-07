<?php

declare(strict_types=1);

namespace App\DataFixtures;

use App\Factory\ArticleFactory;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class ArticleFixtures extends Fixture
{
    const int NUMBER_OF_OBJECTS = 50;

    public function load(ObjectManager $manager): void
    {
        ArticleFactory::createMany(self::NUMBER_OF_OBJECTS);
    }
}
