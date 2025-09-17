<?php

declare(strict_types=1);

namespace App\Mapper;

use ApiPlatform\Metadata\IriConverterInterface;
use App\Dto\RequestDto;
use App\Dto\ResponseDto;
use App\Entity\EntityInterface;
use App\Validation\RegexValidations;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\PersistentCollection;
use InvalidArgumentException;
use ReflectionClass;
use ReflectionException;
use ReflectionType;
use Symfony\Component\PropertyAccess\Exception\AccessException;
use Symfony\Component\PropertyAccess\Exception\UnexpectedTypeException;
use Symfony\Component\PropertyAccess\PropertyAccessorInterface;

readonly class Mapper
{
    public function __construct(
        private EntityManagerInterface $entityManager,
        private IriConverterInterface $iriConverter,
        private PropertyAccessorInterface $propertyAccessor,
    ) {}

    /**
     * @param EntityInterface $entity
     * @param class-string $target
     * @return ResponseDto
     * @throws ReflectionException
     */
    public function entityToDto(EntityInterface $entity, string $target): ResponseDto
    {
        $construct = [];
        $responseDto = class_exists($target)
            ? new ReflectionClass($target)
            : throw new ReflectionException('Class not found: ' . $target)
        ;

        if (
            $responseDto->implementsInterface(ResponseDto::class) === false
            || $responseDto->getConstructor() === null
        ) {
            throw new ReflectionException('Dto not found: ' . $target);
        }

        foreach ($responseDto->getConstructor()->getParameters() as $property) {
            $propertyValue = $this->propertyAccessor->getValue($entity, $property->name);
            if (
                $property->getType() instanceof ReflectionType
                && method_exists($property->getType(), 'isBuiltin')
                && method_exists($property->getType(), 'getName')
                && $property->getType()->isBuiltin() === false
                && is_string($property->getType()->getName())
                && class_exists($property->getType()->getName())
                && (new ReflectionClass($property->getType()->getName()))->implementsInterface(ResponseDto::class)
                && $this->propertyAccessor->getValue($entity, $property->name) !== null
            ) {
                $construct[] = ($propertyValue instanceof EntityInterface)
                    ? $this->entityToDto(
                        entity: $propertyValue,
                        target: $property->getType()->getName()
                    )
                    : throw new ReflectionException(
                        'Entity to DTO error, invalid input: '. $property->getType()->getName()
                    )
                ;
                continue;
            }

            $construct[] = (!$propertyValue instanceof PersistentCollection)
                ? $propertyValue
                : throw new ReflectionException(
                    'Not allowed to set Collection as property value: '. $property->getName()
                )
            ;
        }

        $response = $responseDto->newInstance(...$construct);

        return ($response instanceof ResponseDto)
            ? $response
            : throw new ReflectionException('Invalid response: ' . $target)
        ;
    }

    /**
     * @throws AccessException
     * @throws InvalidArgumentException
     * @throws UnexpectedTypeException
     */
    public function merge(RequestDto $dto, EntityInterface $entity): EntityInterface
    {
        $data = (new ReflectionClass($dto))->getProperties();
        foreach ($data as $property) {
            $value = $this->propertyAccessor->getValue($dto, $property->name);

            /** Get value bij IRI */
            if (is_string($value) && preg_match(pattern: RegexValidations::IRI, subject: $value)) {
                $value = $this->getObjectFromIri($value);
            }

            $this->propertyAccessor->setValue($entity, $property->name, $value);
        }

        return $entity;
    }

    /**
     * @throws InvalidArgumentException
     */
    public function getObjectFromIri(string $iri): EntityInterface
    {
        $resource = $this->iriConverter->getResourceFromIri($iri);

        if (!$resource instanceof ResponseDto) {
            throw new InvalidArgumentException('Invalid IRI: ' . $iri);
        }

        if (!property_exists($resource, 'uuid')) {
            throw new InvalidArgumentException('No identifier found in DTO: ' . $iri);
        }

        return $this->entityManager->getRepository(
            'App\\Entity\\'. ucfirst($resource->getShortName())
        )->findOneBy(['uuid' => $resource->uuid]);
    }
}
