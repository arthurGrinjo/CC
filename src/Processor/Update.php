<?php

declare(strict_types=1);

namespace App\Processor;

use ApiPlatform\Doctrine\Orm\State\Options;
use ApiPlatform\Metadata\Operation;
use ApiPlatform\State\ProcessorInterface;
use ApiPlatform\State\Util\StateOptionsTrait;
use App\Controller\Dto\ResponseDto;
use App\Mapper\Mapper;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\Repository\Exception\InvalidMagicMethodCall;
use ReflectionException;
use RuntimeException;
use Symfony\Component\DependencyInjection\Attribute\Autowire;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Validator\Validator\ValidatorInterface;

readonly class Update extends Validator implements ProcessorInterface
{
    use StateOptionsTrait;

    public function __construct(
        private EntityManagerInterface $entityManager,
        private Mapper $mapper,
        #[Autowire(service: 'api_platform.doctrine.orm.state.persist_processor')]
        private ProcessorInterface $persistProcessor,
        protected ValidatorInterface $validator,
    ) {
        parent::__construct($validator);
    }

    /**
     * @throws ReflectionException
     */
    public function process(mixed $data, Operation $operation, array $uriVariables = [], array $context = []): ResponseDto
    {
        $this->validateDto($data);
        $entityClass = $this->getStateOptionsClass($operation, $operation->getClass(), Options::class);

        $updatedEntity = $this->mapper->merge(
            dto: $data,
            entity: $this->entityManager->getRepository($entityClass)->findOneBy($uriVariables),
        );

        try {
            return $this->mapper->entityToDto(
                entity: $this->persistProcessor->process($updatedEntity, $operation, $uriVariables, $context),
                target: $operation->getOutput()['class'],
            );
        } catch (InvalidMagicMethodCall|ReflectionException) {
            throw new RuntimeException("Unable to generate response.", Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}
