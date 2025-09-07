<?php

declare(strict_types=1);

namespace App\DataFixtures;

use App\Factory\CommentFactory;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;

class CommentFixtures extends Fixture implements DependentFixtureInterface
{
    const int NUMBER_OF_OBJECTS = 250;

    public function load(ObjectManager $manager): void
    {
        for ($i = 0; $i < self::NUMBER_OF_OBJECTS; $i++) {
            CommentFactory::createOne();
        }
    }

    public function getDependencies(): array
    {
        return [
            ActivityFixtures::class,
            ClubFixtures::class,
            EventFixtures::class,
            RouteFixtures::class,
            UserFixtures::class,
        ];
    }
}
