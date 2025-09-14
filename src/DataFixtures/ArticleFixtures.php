<?php

declare(strict_types=1);

namespace App\DataFixtures;

use App\DataFixtures\Trait\Numbers;
use App\Factory\ArticleFactory;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class ArticleFixtures extends Fixture
{
    use Numbers;

    public function load(ObjectManager $manager): void
    {
        ArticleFactory::createMany(self::ARTICLES * self::MULTIPLIER);
    }
}
