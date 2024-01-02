<?php

namespace App\Processor\User;

use ApiPlatform\State\ProcessorInterface;
use ApiPlatform\Metadata\Operation;
use App\Dto\User\Request\ResetPasswordRequest;
use App\Entity\User;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

final class CreateUserProcessor implements ProcessorInterface
{
    /**
     * @param ResetPasswordRequest $data
     */
    public function process($data, Operation $operation, array $uriVariables = [], array $context = []): User
    {
        if ('user@example.com' === $data->email) {
            return new User(
                email: $data->email
            );
        }

        throw new NotFoundHttpException();
    }
}