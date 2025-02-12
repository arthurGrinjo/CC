<?php

namespace App\Provider;

use ApiPlatform\Doctrine\Orm\Paginator;
use ApiPlatform\Doctrine\Orm\State\CollectionProvider;
use ApiPlatform\Doctrine\Orm\State\ItemProvider;
use ApiPlatform\Metadata\CollectionOperationInterface;
use ApiPlatform\Metadata\Operation;
use ApiPlatform\State\Pagination\TraversablePaginator;
use ApiPlatform\State\ProviderInterface;
use App\Mapper\Mapper;
use ArrayIterator;
use Doctrine\ORM\EntityNotFoundException;
use Doctrine\ORM\Repository\Exception\InvalidMagicMethodCall;
use ReflectionException;
use Symfony\Component\DependencyInjection\Attribute\Autowire;

final readonly class Provider implements ProviderInterface
{
    public function __construct(
        #[Autowire(service: CollectionProvider::class)] private ProviderInterface $collectionProvider
    ) {}
    public function provide(Operation $operation, array $uriVariables = [], array $context = []): object|array|null
    {
        $entities = $this->collectionProvider->provide($operation, $uriVariables, $context);
        return $entities;
    }
}
//        $entity = $operation->getStateOptions()->getEntityClass();
//        $output = $operation->getOutput();
//
//        if ($operation instanceof CollectionOperationInterface) {
//            $objects = $this->collectionProvider->provide($operation, $uriVariables, $context);
//
//            $data = [];
//            foreach ($objects as $object) {
//                $data[] = ($object instanceof $entity)
//                    ? $this->mapper->toDto(output: $output['class'], entity: $object)
//                    : throw new EntityNotFoundException($operation->getShortName() . ' does not exist');
//            }
//
//            return ($objects instanceof Paginator)
//                ? new TraversablePaginator(
//                    new ArrayIterator($data),
//                    $objects->getCurrentPage(),
//                    $objects->getItemsPerPage(),
//                    $objects->getTotalItems(),
//                )
//                : $data;
//        }
//
//        $object = $this->itemProvider->provide($operation, $uriVariables, $context);
//
//        return $object instanceof $entity
//            ? $this->mapper->toDto(output: $output['class'], entity: $object)
//            : throw new EntityNotFoundException($operation->getShortName() . ' does not exist');
//    }
//}