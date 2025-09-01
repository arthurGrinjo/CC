<?php

declare(strict_types=1);

namespace App\DataFixtures;

use App\Factory\RouteFactory;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class RouteFixtures extends Fixture
{
    const int NUMBER_OF_OBJECTS = 15;

    public function load(ObjectManager $manager): void
    {
        RouteFactory::createMany(self::NUMBER_OF_OBJECTS);
    }
}
