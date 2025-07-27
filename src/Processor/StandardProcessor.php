<?php

declare(strict_types=1);

namespace App\Processor;

use ApiPlatform\Doctrine\Common\State\RemoveProcessor;
use ApiPlatform\Doctrine\Orm\State\Options;
use ApiPlatform\Metadata\Operation;
use ApiPlatform\Metadata\Delete;
use ApiPlatform\Metadata\Post;
use ApiPlatform\Metadata\Put;
use ApiPlatform\State\ProcessorInterface;
use ApiPlatform\State\Util\StateOptionsTrait;
use App\Dto\ResponseDto;
use App\Mapper\Mapper;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\Repository\Exception\InvalidMagicMethodCall;
use ReflectionException;
use RuntimeException;
use Symfony\Component\DependencyInjection\Attribute\Autowire;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Validator\Validator\ValidatorInterface;

readonly class StandardProcessor extends Validator implements ProcessorInterface
{
    use StateOptionsTrait;

    public function __construct(
        private EntityManagerInterface $entityManager,
        private Mapper $mapper,
        #[Autowire(service: 'api_platform.doctrine.orm.state.persist_processor')]
        private ProcessorInterface $persistProcessor,
        private RemoveProcessor $removeProcessor,
        protected ValidatorInterface $validator,
    ) {
        parent::__construct($validator);
    }

    /**
     * @throws RuntimeException|ReflectionException
     */
    public function process(mixed $data, Operation $operation, array $uriVariables = [], array $context = []): ResponseDto|int
    {
        $entityClass = $this->getStateOptionsClass($operation, $operation->getClass(), Options::class);

        switch(true) {
            case $operation instanceof Post:
                $this->validateDto($data);
                return $this->create($entityClass, $data, $operation, $uriVariables, $context);
            case $operation instanceof Put:
                $this->validateDto($data);
                return $this->update($entityClass, $data, $operation, $uriVariables, $context);
            case $operation instanceof Delete:
                $this->removeProcessor->process($data, $operation, $uriVariables, $context);
                return Response::HTTP_NO_CONTENT;
            default:
                throw new RuntimeException('Could not process request.');
        }
    }

    private function create(
        string $entityClass,
        mixed $data,
        Operation $operation,
        array $uriVariables,
        array $context,
    ): ResponseDto {
        try {
            $entity = $this->mapper->merge(
                dto: $data,
                entity: new $entityClass,
            );

            return $this->mapper->entityToDto(
                entity: $this->persistProcessor->process($entity, $operation, $uriVariables, $context),
                target: $operation->getOutput()['class'],
            );
        } catch (InvalidMagicMethodCall|ReflectionException) {
            throw new RuntimeException("Unable to generate response.", Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    private function update(
        string $entityClass,
        mixed $data,
        Operation $operation,
        array $uriVariables = [],
        array $context = []
    ): ResponseDto {
        try {
            $updatedEntity = $this->mapper->merge(
                dto: $data,
                entity: $this->entityManager->getRepository($entityClass)->findOneBy($uriVariables),
            );

            return $this->mapper->entityToDto(
                entity: $this->persistProcessor->process($updatedEntity, $operation, $uriVariables, $context),
                target: $operation->getOutput()['class'],
            );
        } catch (InvalidMagicMethodCall|ReflectionException) {
            throw new RuntimeException("Unable to generate response.", Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}
