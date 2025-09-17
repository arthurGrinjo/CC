<?php

declare(strict_types=1);

namespace App\DataFixtures;

use App\DataFixtures\Trait\Numbers;
use App\Factory\MemberFactory;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;

class MemberFixtures extends Fixture implements DependentFixtureInterface
{
    use Numbers;

    public function load(ObjectManager $manager): void
    {
        /**
         * for-loop to force db flush per item.
         */
        for ($i = 0; $i < (self::MEMBERS * self::MULTIPLIER); $i++) {
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
