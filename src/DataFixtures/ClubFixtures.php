<?php

declare(strict_types=1);

namespace App\DataFixtures;

use App\DataFixtures\Trait\Numbers;
use App\Factory\ClubFactory;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class ClubFixtures extends Fixture
{
    use Numbers;

    public function load(ObjectManager $manager): void
    {
        ClubFactory::createMany(self::CLUBS * self::MULTIPLIER);
    }
}
