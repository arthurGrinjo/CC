<?php

declare(strict_types=1);

namespace App\DataFixtures;

use App\Factory\GearFactory;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;

class GearFixtures extends Fixture implements DependentFixtureInterface
{
    const int NUMBER_OF_OBJECTS = 15;

    public function load(ObjectManager $manager): void
    {
        GearFactory::createMany(self::NUMBER_OF_OBJECTS);
    }

    public function getDependencies(): array
    {
        return [
            UserFixtures::class,
        ];
    }
}
