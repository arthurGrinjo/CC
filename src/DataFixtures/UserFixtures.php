<?php

namespace App\DataFixtures;

use App\Entity\User;
use App\Factory\UserFactory;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;
use Faker\Generator;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class UserFixtures extends Fixture
{
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

        UserFactory::createMany(50);
    }
}
