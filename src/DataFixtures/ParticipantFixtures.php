<?php

declare(strict_types=1);

namespace App\DataFixtures;

use App\Factory\ParticipantFactory;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;

class ParticipantFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager): void
    {
        ParticipantFactory::createMany(100);
    }

    public function getDependencies(): array
    {
        return [
            UserFixtures::class,
            EventFixtures::class,
        ];
    }
}
