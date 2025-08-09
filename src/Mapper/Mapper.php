<?php

declare(strict_types=1);

namespace App\Mapper;

use App\Dto\ResponseDto;
use App\Dto\RequestDto;
use App\Entity\EntityInterface;
use App\Entity\Identifiers\IdentifierInterface;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\Repository\Exception\InvalidMagicMethodCall;
use ReflectionClass;
use ReflectionException;
use ReflectionProperty;
use ReflectionType;
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

        if (
            $responseDto->implementsInterface(ResponseDto::class) === false
            || $responseDto->getConstructor() === null
        ) {
            throw new ReflectionException('Dto not found: ' . $target);
        }

        foreach ($responseDto->getConstructor()->getParameters() as $property) {
            if (
                $property->getType() instanceof ReflectionType
                && method_exists($property->getType(), 'isBuiltin')
                && method_exists($property->getType(), 'getName')
                && $property->getType()->isBuiltin() === false
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
        /** todo: try to handle with ObjectId's, e.g. EventId, ParticipantId, UserId etc. */
        $data = (new ReflectionClass($dto))->getProperties();
        foreach ($data as $property) {
            $value = $this->propertyAccessor->getValue($dto, $property->name);

            /** instanceof IdentityInterface, then */
            if ($value instanceof IdentifierInterface && $value instanceof Uuid) {
                $repository = $this->entityManager->getRepository($value->getClass());
                $value = $repository->findOneBy(['uuid' => $value]);
            }
            $this->propertyAccessor->setValue($entity, $property->name, $value);
        }

        return $entity;
    }
}
