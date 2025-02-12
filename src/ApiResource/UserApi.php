<?php

namespace App\ApiResource;

use ApiPlatform\Doctrine\Orm\Filter\SearchFilter;
use ApiPlatform\Doctrine\Orm\State\Options;
use ApiPlatform\Metadata\ApiFilter;
use ApiPlatform\Metadata\ApiResource;
use App\Entity\User;
use App\Provider\UserProvider;
use Symfony\Component\Uid\Uuid;

#[ApiResource(
    shortName: 'User',
    paginationItemsPerPage: 5,
    provider: UserProvider::class,
    stateOptions: new Options(User::class),
)]
#[ApiFilter(SearchFilter::class, properties: [
    'email' => 'partial'
])]
class UserApi
{
    public ?int $id = null;

    public ?Uuid $uuid = null;

    public string $email;

    public int $something;
}