<?php

declare(strict_types=1);

namespace App\Processor\User;

use ApiPlatform\Metadata\Operation;
use ApiPlatform\State\ProcessorInterface;
use App\Dto\ResponseDto;
use App\Dto\User\Request\UserRequestDto;
use App\Dto\User\Response\UserResponseDto;
use App\Entity\User;
use App\Mapper\Mapper;
use App\Processor\Validator;
use Doctrine\ORM\Repository\Exception\InvalidMagicMethodCall;
use ReflectionException;
use RuntimeException;
use Symfony\Component\DependencyInjection\Attribute\Autowire;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Validator\Validator\ValidatorInterface;

readonly class CreateUser extends Validator implements ProcessorInterface
{
    public function __construct(
        private Mapper $mapper,
        #[Autowire(service: 'api_platform.doctrine.orm.state.persist_processor')]
        private ProcessorInterface $persistProcessor,
        protected ValidatorInterface $validator,
    ) {
        parent::__construct($validator);
    }

    /**
     * @throws RuntimeException
     */
    public function process(mixed $data, Operation $operation, array $uriVariables = [], array $context = []): ResponseDto
    {
        if (!$data instanceof UserRequestDto) {
            throw new RuntimeException("Invalid input.", Response::HTTP_BAD_REQUEST);
        }

        $this->validateDto($data);

        $user = $this->mapper->merge(dto: $data, entity: new User());

        try {
            return $this->mapper->entityToDto(
                entity: $this->persistProcessor->process($user, $operation, $uriVariables, $context),
                target: UserResponseDto::class,
            );
        } catch (InvalidMagicMethodCall|ReflectionException) {
            throw new RuntimeException("Unable to generate response.", Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}