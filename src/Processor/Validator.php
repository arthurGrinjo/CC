<?php

namespace App\Processor;

use ApiPlatform\Validator\Exception\ValidationException;
use App\Dto\RequestDto;
use App\Dto\ResponseDto;
use Symfony\Component\Validator\Validator\ValidatorInterface;

readonly class Validator
{
    public function __construct(
        private ValidatorInterface $validator,
    ) {}

    /**
     * @throws ValidationException
     */
    public function validateDto(RequestDto|ResponseDto $object): void
    {
        $violations = $this->validator->validate($object);
        $messages = [];

        foreach ($violations as $violation) {
            $messages[$violation->getPropertyPath()][] = $violation->getMessage();
        }

        if (count($messages) > 0) {
            throw new ValidationException(
                message: 'Some fields are incorrect.',
            );
        }
    }
}
