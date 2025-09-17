<?php

declare(strict_types=1);

namespace App\DataFixtures;

use App\DataFixtures\Trait\Numbers;
use App\Factory\RouteFactory;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class RouteFixtures extends Fixture
{
    use Numbers;

    public function load(ObjectManager $manager): void
    {
        RouteFactory::createMany(self::ROUTES * self::MULTIPLIER);
    }
}
