<?php

declare(strict_types=1);

namespace App\DataFixtures\Trait;

trait Numbers
{
    private const int MULTIPLIER = 1;
    public const int ACTIVITIES = 30;
    public const int ARTICLES = 10;

    public const int CHATS = 25;
    public const int CLUBS = 2;

    /** @var array<string, int> */
    public const array COMMENTS = ['min' => 3, 'max' => 20];
    public const int EVENTS = 5;
    public const int GEARS = 10;
    public const int MEMBERS = 10;
    public const int PARTICIPANTS = 20;
    public const int ROUTES = 20;
    public const int USERS = 10;
}
