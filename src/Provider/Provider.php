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
use InvalidArgumentException;
use ReflectionException;
use RuntimeException;
use Symfony\Component\PropertyAccess\Exception\AccessException;
use Symfony\Component\PropertyAccess\Exception\UnexpectedTypeException;

/**
 * @template T of object
 * @implements ProviderInterface<T>
 */
final readonly class Provider implements ProviderInterface
{
    public function __construct(
        private CollectionProvider $collectionProvider,
        private ItemProvider       $itemProvider,
        private Mapper             $mapper,
    ){}

    /**
     * @inheritDoc
     */
    public function provide(Operation $operation, array $uriVariables = [], array $context = []): object|array|null
    {
        try {
            $stateOptions = $operation->getStateOptions();
            if (!$stateOptions instanceof Options) {
                return null;
            }

            $entityClass = $stateOptions->getEntityClass();
            $output = $operation->getOutput();

            if (
                (
                    is_array($output)
                    && array_key_exists('class', $output)
                    && is_string($output['class'])
                    && class_exists($output['class'])
                ) === false
            ) {
                throw new RuntimeException('Invalid output class: ');
            }

            if ($operation instanceof CollectionOperationInterface) {
                $data = [];
                $objects = $this->collectionProvider->provide($operation, $uriVariables, $context);

                /** @var EntityInterface $object */
                foreach ($objects as $object) {
                    if (!$object instanceof $entityClass) {
                        throw new EntityNotFoundException('Entity not found: ' . serialize($object));
                    }

                    $data[] = $this->mapper->entityToDto(entity: $object, target: $output['class']);
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

            return ($object instanceof $entityClass)
                ? $this->mapper->entityToDto(entity: $object, target: $output['class'])
                : throw new EntityNotFoundException('Entity not found: ' . serialize($object));
        } catch (
            AccessException
            | EntityNotFoundException
            | InvalidArgumentException
            | ReflectionException
            | RuntimeException
            | UnexpectedTypeException $e
        ) {
            throw new RuntimeException('Unable to provide: ' . $e->getMessage());
        }
    }
}
