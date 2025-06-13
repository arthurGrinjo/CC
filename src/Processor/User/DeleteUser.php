<?php

declare(strict_types=1);

namespace App\Processor\User;

use ApiPlatform\Metadata\Operation;
use ApiPlatform\State\ProcessorInterface;
use ApiPlatform\Validator\Exception\ValidationException;
use App\Entity\User;
use App\Processor\Validator;
use http\Exception\RuntimeException;
use Symfony\Component\DependencyInjection\Attribute\Autowire;
use Symfony\Component\Validator\Validator\ValidatorInterface;

readonly class DeleteUser extends Validator implements ProcessorInterface
{
    public function __construct(
        #[Autowire(service: 'api_platform.doctrine.orm.state.remove_processor')]
        private ProcessorInterface $removeProcessor,
        protected ValidatorInterface $validator,
    ) {
        parent::__construct($validator);
    }

    /**
     * @throws RuntimeException
     */
    public function process(mixed $data, Operation $operation, array $uriVariables = [], array $context = [])
    {
        if (!$data instanceof User) {
            throw new ValidationException('Not a valid user.');
        }

        return $this->removeProcessor->process($data, $operation, $uriVariables, $context);
    }
}