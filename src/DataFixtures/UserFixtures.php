<?php

declare(strict_types=1);

namespace App\DataFixtures;

use App\Factory\UserFactory;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class UserFixtures extends Fixture
{
    const int NUMBER_OF_OBJECTS = 50;
    private const PASSWORD = 'test123!';
    private const PREDEFINED_USERS = array(
        array(
            'email' => 'arthur@grinjo.nl',
            'roles' => ['ROLE_ADMIN'],
            'password' => self::PASSWORD,
            'first_name' => 'Arthur',
            'last_name' => 'Beheerder',
        ),
        array(
            'email' => 'user@grinjo.nl',
            'roles' => ['ROLE_USER'],
            'password' => self::PASSWORD,
            'first_name' => 'Arthur',
            'last_name' => 'Gebruiker',
        ),
    );

    public function load(ObjectManager $manager): void
    {
        foreach (self::PREDEFINED_USERS as $user) {
            UserFactory::createOne($user);
        }

        UserFactory::createMany(self::NUMBER_OF_OBJECTS);
    }
}
