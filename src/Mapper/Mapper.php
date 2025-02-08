<?php

namespace App\Mapper;

use App\Dto\Response;
use App\Entity\EntityInterface;
use AutoMapper\AutoMapperInterface;
use Doctrine\ORM\Repository\Exception\InvalidMagicMethodCall;
use ReflectionClass;
use ReflectionException;

class Mapper
{
    public function __construct(
        private readonly AutoMapperInterface $autoMapper,
    )
    {
    }

    /**
     * @throws ReflectionException
     */
    public function toDto(string $output, EntityInterface $entity): Response
    {
        return $this->autoMapper->map($entity, $output);
//        $construct = [];
//        $responseDto = new ReflectionClass($output);
//        if ($responseDto->implementsInterface(Response::class) === false) {
//            throw new ReflectionException('No dto response found: ' . $output);
//        }
//
//        foreach ($responseDto->getConstructor()->getParameters() as $property) {
//            $func = 'get' . ucfirst($property->name);
//
//            if (
//                $property->getType()->isBuiltin() === false
//                && (new ReflectionClass($property->getType()->getName()))->implementsInterface(Response::class)
//            ) {
//                $construct[] = $this->toDto(output: $property->getType()->getName(), entity: $entity->$func());
//                continue;
//            }
//
//            if (method_exists($entity, $func) === false) {
//                throw new InvalidMagicMethodCall('Could not find setterMethod: ' . $func);
//            }
//
//            $construct[] = $entity->$func();
//        }
//
//        return $responseDto->newInstance(...$construct);
    }
}