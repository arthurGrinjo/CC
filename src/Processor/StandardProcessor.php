<?php

declare(strict_types=1);

namespace App\Processor;

use ApiPlatform\Doctrine\Common\State\RemoveProcessor;
use ApiPlatform\Doctrine\Orm\State\Options;
use ApiPlatform\Metadata\Delete;
use ApiPlatform\Metadata\Operation;
use ApiPlatform\Metadata\Post;
use ApiPlatform\Metadata\Put;
use ApiPlatform\State\ProcessorInterface;
use App\Dto\RequestDto;
use App\Dto\ResponseDto;
use App\Entity\EntityInterface;
use App\Mapper\Mapper;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\Repository\Exception\InvalidMagicMethodCall;
use ReflectionException;
use RuntimeException;
use Symfony\Component\DependencyInjection\Attribute\Autowire;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Validator\Validator\ValidatorInterface;

/**
 * @template T1
 * @template T2
 *
 * @implements ProcessorInterface<T1, T2>
 */
readonly class StandardProcessor extends Validator implements ProcessorInterface
{
    /**
     * @param ProcessorInterface<T1, T2> $persistProcessor
     */
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
     * @inheritDoc
     * @throws RuntimeException
     */
    public function process(mixed $data, Operation $operation, array $uriVariables = [], array $context = []): ResponseDto|int
    {
        $entityClass = ($operation->getStateOptions() instanceof Options)
            ? $operation->getStateOptions()->getEntityClass()
            : throw new RuntimeException('Provider: No entity class defined.')
        ;

        if (!is_string($entityClass) || !class_exists($entityClass)) {
            throw new RuntimeException('Provider: Not a valid EntityClass.');
        }

        switch(true) {
            case (
                $operation instanceof Post
                || $operation instanceof Put
            ) && $data instanceof RequestDto:
                $this->validateDto($data);
                return $this->updateOrCreate($entityClass, $data, $operation, $uriVariables, $context);
            case $operation instanceof Delete:
                $this->removeProcessor->process($data, $operation, $uriVariables, $context);
                return Response::HTTP_NO_CONTENT;
            default:
                throw new RuntimeException('Cannot process this request.', Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    /**
     * @param T1 $data
     * @param array<string, mixed> $uriVariables
     * @param array<string, mixed>&array{request?: Request, previous_data?: mixed, resource_class?: string|null, original_data?: mixed} $context
     * @throws RuntimeException
     */
    private function updateOrCreate(
        string $entityClass,
        mixed $data,
        Operation $operation,
        array $uriVariables,
        array $context,
    ): ResponseDto {
        try {
            $entity = null;
            if ($operation instanceof Post) {
                $entity = new $entityClass;
            }

            if ($operation instanceof Put) {
                $repo = $this->entityManager->getRepository($entityClass);
                $entity = $repo->findOneBy($uriVariables);
            }

            ($data instanceof RequestDto && $entity instanceof EntityInterface)
                ? $this->mapper->merge(
                    dto: $data,
                    entity: $entity,
                )
                : throw new ReflectionException('Invalid input dto.')
            ;

            return (
                is_array($operation->getOutput())
                && array_key_exists('class', $operation->getOutput())
                && is_string($operation->getOutput()['class'])
                && class_exists($operation->getOutput()['class'])
            )
                ? $this->mapper->entityToDto(
                    entity: $this->persistProcessor->process($entity, $operation, $uriVariables, $context),
                    target: $operation->getOutput()['class'],
                )
                : throw new RuntimeException('Invalid output class, create: ' . $entityClass)
            ;
        } catch (InvalidMagicMethodCall|ReflectionException|RuntimeException $e) {
            throw new RuntimeException($e->getMessage(), $e->getCode());
        }
    }
}
