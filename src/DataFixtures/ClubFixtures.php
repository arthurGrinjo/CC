<?php

declare(strict_types=1);

namespace App\DataFixtures;

use App\Factory\ClubFactory;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class ClubFixtures extends Fixture
{
    const int NUMBER_OF_OBJECTS = 15;

    public function load(ObjectManager $manager): void
    {
        ClubFactory::createMany(5);
    }
}
