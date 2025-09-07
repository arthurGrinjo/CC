<?php

declare(strict_types=1);

namespace App\DataFixtures;

use App\Factory\MemberFactory;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;

class MemberFixtures extends Fixture implements DependentFixtureInterface
{
    const int NUMBER_OF_OBJECTS = 100;

    public function load(ObjectManager $manager): void
    {
        for ($i = 0; $i < self::NUMBER_OF_OBJECTS; $i++) {
            MemberFactory::createOne();
        }
    }

    public function getDependencies(): array
    {
        return [
            ClubFixtures::class,
            UserFixtures::class,
        ];
    }
}
