<?php

namespace App\Dto\User\Response;

use ApiPlatform\Metadata\ApiResource;
use App\Dto\Response;
use App\Dto\User\User;

#[ApiResource(
    operations: [],
    routePrefix: 'users',
)]
class UserResponse implements Response
{
    public function __construct(
        private string $uuid,
        private string $email,
        private array $roles,
    ){
        $this
            ->setId($uuid)
            ->setEmail($email)
            ->setRoles($roles)
        ;
    }

    /**
     * @return string
     */
    public function getId(): string
    {
        return $this->uuid;
    }

    /**
     * @param string $uuid
     * @return UserResponse
     */
    public function setId(string $uuid): static
    {
        $this->uuid = $uuid;
        return $this;
    }

    /**
     * @return string
     */
    public function getEmail(): string
    {
        return $this->email;
    }

    /**
     * @param string $email
     * @return UserResponse
     */
    public function setEmail(string $email): static
    {
        $this->email = $email;
        return $this;
    }

    /**
     * @return array
     */
    public function getRoles(): array
    {
        return $this->roles;
    }

    /**
     * @param array $roles
     * @return UserResponse
     */
    public function setRoles(array $roles): UserResponse
    {
        $this->roles = $roles;
        return $this;
    }
}