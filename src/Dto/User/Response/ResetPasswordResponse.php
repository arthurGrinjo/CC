<?php

namespace App\Dto\User\Response;

use ApiPlatform\Metadata\ApiResource;
use App\Dto\Response;
use App\Dto\User\User;

#[ApiResource(
    operations: [],
)]
class ResetPasswordResponse implements Response
{
    public function __construct(
        private string $uuid,
        private string $email,
    ){
        $this
            ->setId($uuid)
            ->setEmail($email)
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
     * @return ResetPasswordResponse
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
     * @return ResetPasswordResponse
     */
    public function setEmail(string $email): static
    {
        $this->email = $email;
        return $this;
    }
}