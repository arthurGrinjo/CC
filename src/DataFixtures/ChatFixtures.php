<?php

declare(strict_types=1);

namespace App\DataFixtures;

use App\DataFixtures\Trait\Numbers;
use App\Factory\ChatFactory;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;

class ChatFixtures extends Fixture implements DependentFixtureInterface
{
    use Numbers;

    public function load(ObjectManager $manager): void
    {
        ChatFactory::createMany(self::CHATS * self::MULTIPLIER);
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
