<?php

namespace App\DataFixtures;

use App\Factory\EventFactory;
use App\Factory\ParticipantFactory;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;

class ParticipantFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager): void
    {
        ParticipantFactory::createMany(40);
    }

    public function getDependencies(): array
    {
        return [
            UserFixtures::class,
            EventFixtures::class,
        ];
    }
}
