<?php

declare(strict_types=1);

namespace App\Mapper;

use App\Dto\ResponseDto;
use App\Dto\RequestDto;
use App\Entity\EntityInterface;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\Repository\Exception\InvalidMagicMethodCall;
use ReflectionClass;
use ReflectionException;
use ReflectionProperty;
use Symfony\Component\PropertyAccess\PropertyAccessorInterface;
use Symfony\Component\Uid\Uuid;

readonly class Mapper
{
    public function __construct(
        private EntityManagerInterface $entityManager,
        private PropertyAccessorInterface $propertyAccessor,
    ) {}

    /**
     * @throws ReflectionException|InvalidMagicMethodCall
     */
    public function entityToDto(EntityInterface $entity, string $target): ResponseDto
    {
        $construct = [];
        $responseDto = new ReflectionClass($target);

        if ($responseDto->implementsInterface(ResponseDto::class) === false) {
            throw new ReflectionException('Dto not found: ' . $target);
        }

        foreach ($responseDto->getConstructor()->getParameters() as $property) {
            if (
                $property->getType()->isBuiltin() === false
                && (new ReflectionClass($property->getType()->getName()))->implementsInterface(ResponseDto::class)
            ) {
                $construct[] = $this->entityToDto(
                    entity: $this->propertyAccessor->getValue($entity, $property->name),
                    target: $property->getType()->getName()
                );
                continue;
            }

            $construct[] = $this->propertyAccessor->getValue($entity, $property->name);
        }

        return $responseDto->newInstance(...$construct);
    }

    /**
     * @throws ReflectionException
     */
    public function merge(RequestDto $dto, EntityInterface $entity): EntityInterface
    {
        foreach ($dto as $key => $value) {
            if ($value instanceof Uuid || is_int($value)) {
                $property = new ReflectionProperty($entity, $key);
                $repository = $this->entityManager->getRepository($property->getType()->getName());
                $value = $repository->findOneBy($value instanceof Uuid
                    ? ['uuid' => $value]
                    : ['id' => $value]
                );
            }
            $this->propertyAccessor->setValue($entity, $key, $value);
        }

        return $entity;
    }
}
