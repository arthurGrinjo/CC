<?php

declare(strict_types=1);

namespace App\DataFixtures;

use App\Factory\ParticipantFactory;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;

class ParticipantFixtures extends Fixture implements DependentFixtureInterface
{
    const int NUMBER_OF_OBJECTS = 100;

    public function load(ObjectManager $manager): void
    {
        for ($i = 0; $i < self::NUMBER_OF_OBJECTS; $i++) {
            ParticipantFactory::createOne();
        }
    }

    public function getDependencies(): array
    {
        return [
            UserFixtures::class,
            EventFixtures::class,
        ];
    }
}
