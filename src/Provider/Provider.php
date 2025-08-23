<?php

declare(strict_types=1);

namespace App\Provider;

use ApiPlatform\Doctrine\Orm\Paginator;
use ApiPlatform\Doctrine\Orm\State\CollectionProvider;
use ApiPlatform\Doctrine\Orm\State\ItemProvider;
use ApiPlatform\Doctrine\Orm\State\Options;
use ApiPlatform\Metadata\CollectionOperationInterface;
use ApiPlatform\Metadata\Operation;
use ApiPlatform\State\Pagination\TraversablePaginator;
use ApiPlatform\State\ProviderInterface;
use App\Entity\EntityInterface;
use App\Mapper\Mapper;
use ArrayIterator;
use Doctrine\ORM\EntityNotFoundException;
use Exception;
use ReflectionException;
use RuntimeException;

/**
 * @implements ProviderInterface<EntityInterface|null>
 */
final readonly class Provider implements ProviderInterface
{
    public function __construct(
        private CollectionProvider $collectionProvider,
        private ItemProvider       $itemProvider,
        private Mapper             $mapper,
    ){}

    /**
     * @return object|array<EntityInterface>|object[]
     * @throws ReflectionException
     * @throws Exception
     */
    public function provide(Operation $operation, array $uriVariables = [], array $context = []): object|array
    {
        $entityClass = ($operation->getStateOptions() instanceof Options)
            ? $operation->getStateOptions()->getEntityClass()
            : throw new RuntimeException('Provider: No entity class defined.');

        /** @var array{class: string, name: string} $output */
        $output = $operation->getOutput();

        if ($operation instanceof CollectionOperationInterface) {
            $data = [];
            $objects = $this->collectionProvider->provide($operation, $uriVariables, $context);

            /** @var EntityInterface $object */
            foreach ($objects as $object) {
                $data[] = ($object instanceof $entityClass)
                    ? $this->mapper->entityToDto(entity: $object, target: $output['class'])
                    : throw new EntityNotFoundException($operation->getShortName() . ' does not exist');
            }

            return ($objects instanceof Paginator)
                ? new TraversablePaginator(
                    new ArrayIterator($data),
                    $objects->getCurrentPage(),
                    $objects->getItemsPerPage(),
                    $objects->getTotalItems(),
                )
                : $data;
        }

        /** @var EntityInterface $object */
        $object = $this->itemProvider->provide($operation, $uriVariables, $context);

        return $object instanceof $entityClass
            ? $this->mapper->entityToDto(entity: $object, target: $output['class'])
            : throw new EntityNotFoundException($operation->getShortName() . ' does not exist');
    }
}
