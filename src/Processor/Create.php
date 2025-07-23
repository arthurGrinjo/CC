<?php

declare(strict_types=1);

namespace App\Processor;

use ApiPlatform\Doctrine\Orm\State\Options;
use ApiPlatform\Metadata\Operation;
use ApiPlatform\State\ProcessorInterface;
use ApiPlatform\State\Util\StateOptionsTrait;
use App\Controller\Dto\ResponseDto;
use App\Mapper\Mapper;
use Doctrine\ORM\Repository\Exception\InvalidMagicMethodCall;
use ReflectionException;
use RuntimeException;
use Symfony\Component\DependencyInjection\Attribute\Autowire;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Validator\Validator\ValidatorInterface;

readonly class Create extends Validator implements ProcessorInterface
{
    use StateOptionsTrait;

    public function __construct(
        private Mapper $mapper,
        #[Autowire(service: 'api_platform.doctrine.orm.state.persist_processor')]
        private ProcessorInterface $persistProcessor,
        protected ValidatorInterface $validator,
    ) {
        parent::__construct($validator);
    }

    /**
     * @throws RuntimeException|ReflectionException
     */
    public function process(mixed $data, Operation $operation, array $uriVariables = [], array $context = []): ResponseDto
    {
        $entityClass = $this->getStateOptionsClass($operation, $operation->getClass(), Options::class);
        $entity = $this->mapper->merge(
            dto: $data,
            entity: new $entityClass,
        );

        try {
            return $this->mapper->entityToDto(
                entity: $this->persistProcessor->process($entity, $operation, $uriVariables, $context),
                target: $operation->getOutput()['class'],
            );
        } catch (InvalidMagicMethodCall|ReflectionException) {
            throw new RuntimeException("Unable to generate response.", Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}
