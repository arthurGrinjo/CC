<?php

declare(strict_types=1);

namespace App\Processor\User;

use ApiPlatform\Metadata\Operation;
use ApiPlatform\State\ProcessorInterface;
use App\Dto\ResponseDto;
use App\Dto\User\Request\UserRequestPutDto;
use App\Dto\User\Response\UserResponseDto;
use App\Entity\User;
use App\Mapper\Mapper;
use App\Processor\Validator;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityNotFoundException;
use Doctrine\ORM\Repository\Exception\InvalidMagicMethodCall;
use InvalidArgumentException;
use ReflectionException;
use RuntimeException;
use Symfony\Component\DependencyInjection\Attribute\Autowire;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Uid\Uuid;
use Symfony\Component\Validator\Validator\ValidatorInterface;

readonly class UpdateUser extends Validator implements ProcessorInterface
{
    public function __construct(
        private Mapper $mapper,
        #[Autowire(service: 'api_platform.doctrine.orm.state.persist_processor')]
        private ProcessorInterface $persistProcessor,
        private UserRepository $userRepository,
        protected ValidatorInterface $validator,
    ) {
        parent::__construct($validator);
    }

    /**
     * @throws RuntimeException
     * @throws EntityNotFoundException
     */
    public function process(mixed $data, Operation $operation, array $uriVariables = [], array $context = []): ResponseDto
    {
        if (!$data instanceof UserRequestPutDto) {
            throw new RuntimeException("Invalid input.", Response::HTTP_BAD_REQUEST);
        }

        $this->validateDto($data);

        if (array_key_exists('uuid', $uriVariables) === false || !$uriVariables['uuid'] instanceof Uuid) {
            throw new InvalidArgumentException('Query parameter "uuid" is missing or not a valid uuid');
        }

        /** Updated User */
        $user = $this->mapper->merge(
            dto: $data,
            entity: $this->userRepository->getByUuid($uriVariables['uuid']),
        );

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