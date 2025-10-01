<?php

declare(strict_types=1);

namespace App\DataFixtures;

use App\DataFixtures\Trait\Numbers;
use App\Factory\EventFactory;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;

class EventFixtures extends Fixture implements DependentFixtureInterface
{
    use Numbers;

    public function load(ObjectManager $manager): void
    {
        EventFactory::createMany(self::EVENTS * self::MULTIPLIER);
    }

    public function getDependencies(): array
    {
        return [
            LocationFixtures::class,
        ];
    }
}
