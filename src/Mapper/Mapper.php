<?php

declare(strict_types=1);

namespace App\Mapper;

use App\Dto\Dto;
use App\Dto\ResponseDto;
use App\Entity\EntityInterface;
use Doctrine\ORM\Repository\Exception\InvalidMagicMethodCall;
use ReflectionClass;
use ReflectionException;
use Symfony\Component\PropertyAccess\PropertyAccessorInterface;

readonly class Mapper
{
    public function __construct(
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

    public function merge(Dto $dto, EntityInterface $entity): EntityInterface
    {
        foreach ($dto as $key => $value) {
            $this->propertyAccessor->setValue($entity, $key, $value);
        }

        return $entity;
    }
}