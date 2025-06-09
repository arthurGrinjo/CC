<?php

declare(strict_types=1);

namespace App\Mapper;

use App\Dto\Response;
use App\Entity\EntityInterface;
use Doctrine\ORM\Repository\Exception\InvalidMagicMethodCall;
use ReflectionClass;
use ReflectionException;

class Mapper
{
    /**
     * @throws ReflectionException|InvalidMagicMethodCall
     * todo: perhaps implement PropertyAccessor
     */
    public function toDto(string $output, EntityInterface $entity): Response
    {
        $construct = [];
        $responseDto = new ReflectionClass($output);
        if ($responseDto->implementsInterface(Response::class) === false) {
            throw new ReflectionException('No dto response found: ' . $output);
        }

        foreach ($responseDto->getConstructor()->getParameters() as $property) {
            $func = 'get' . ucfirst($property->name);

            if (!method_exists($entity, $func)) {
                $func = 'is' . ucfirst($property->name);
            }

            if (method_exists($entity, $func) === false) {
                throw new InvalidMagicMethodCall(
                    sprintf('Could not find getMethod for: %s', $property->getName())
                );
            }

            if (
                $property->getType()->isBuiltin() === false
                && (new ReflectionClass($property->getType()->getName()))->implementsInterface(Response::class)
            ) {
                $construct[] = $this->toDto(
                    output: $property->getType()->getName(),
                    entity: $entity->$func()
                );
                continue;
            }

            $construct[] = $entity->$func();
        }

        return $responseDto->newInstance(...$construct);
    }
}