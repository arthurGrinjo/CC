<?php

declare(strict_types=1);

namespace App\DataFixtures;

use App\DataFixtures\Trait\Numbers;
use App\Factory\ClubFactory;
use App\Factory\LocationFactory;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class LocationFixtures extends Fixture
{
    use Numbers;

    public function load(ObjectManager $manager): void
    {
        LocationFactory::createMany(self::LOCATIONS * self::MULTIPLIER);
    }
}
