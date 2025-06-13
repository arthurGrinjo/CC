<?php

declare(strict_types=1);

namespace App\Repository\Trait;

use App\Entity\EntityInterface;
use DateTime;
use Doctrine\DBAL\Exception;
use Doctrine\ORM\EntityNotFoundException;
use InvalidArgumentException;
use Symfony\Component\Uid\Uuid;
use function method_exists;
use function sprintf;

/**
 * @template E of EntityInterface
 */
trait EntityRepository
{
    /**
     * @return EntityInterface|null
     * @throws InvalidArgumentException
     * @deprecated use getByUuid instead
     */
    public function findByUuid(Uuid|string $uuid)
    {
        if (!$uuid instanceof Uuid) {
            $uuid = Uuid::fromString($uuid);
        }

        /** @var EntityInterface|null */
        return $this->findOneBy(['uuid' => $uuid->toRfc4122()]);
    }

    /**
     * @return EntityInterface
     * @throws EntityNotFoundException
     * @throws InvalidArgumentException
     */
    public function getByUuid(Uuid|string $uuid): EntityInterface
    {
        if (!$uuid instanceof Uuid) {
            $uuid = Uuid::fromString($uuid);
        }

        return $this->findOneBy(['uuid' => $uuid->toRfc4122()])
            ?? throw new EntityNotFoundException(sprintf(
                'Entity type "%s" with uuid "%s" not found',
                $this->getClassMetadata()->rootEntityName,
                $uuid->toRfc4122(),
            ));
    }

    /**
     * @return EntityInterface
     */
    public function create(DlpEntity $entity, bool $flush = true): EntityInterface
    {
        $entityManager = $this->getEntityManager();
        $entityManager->persist($entity);

        if ($flush === true) {
            $entityManager->flush();
        }

        /** @var EntityInterface */
        return $entity;
    }

    /**
     * @return EntityInterface
     * @throws EntityNotFoundException
     * @throws InvalidArgumentException
     */
    public function update(Uuid $uuid, EntityInterface $entity, bool $flush = true): EntityInterface
    {
        $newEntity = $this->getByUuid($uuid);
        $this->merge($newEntity, $entity);
        $entityManager = $this->getEntityManager();
        $entityManager->persist($newEntity);

        if ($flush === true) {
            $entityManager->flush();
        }

        /** @var EntityInterface */
        return $newEntity;
    }

    public function remove(DlpEntity $entity, bool $flush = true): void
    {
        $entityManager = $this->getEntityManager();
        method_exists($entity, 'setDeletedAt')
            ? $entityManager->persist($entity->setDeletedAt(new DateTime()))
            : $entityManager->remove($entity);

        if ($flush === true) {
            $entityManager->flush();
        }
    }

    public function flush(): void
    {
        $this->getEntityManager()->flush();
    }

    /**
     * @throws Exception
     */
    public function nextVal(string $sequence): int
    {
        $conn = $this->getEntityManager()->getConnection();
        $stmt = $conn->prepare(sprintf('SELECT nextval(\'%s\')', $sequence));

        /** @var int */
        return $stmt->executeQuery()->fetchOne();
    }
}