<?php

declare(strict_types=1);

namespace App\DataFixtures;

use App\Factory\ActivityFactory;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;

class ActivityFixtures extends Fixture implements DependentFixtureInterface
{
    const int NUMBER_OF_OBJECTS = 15;

    public function load(ObjectManager $manager): void
    {
        ActivityFactory::createMany(5);
    }

    public function getDependencies(): array
    {
        return [
            UserFixtures::class,
        ];
    }
}
