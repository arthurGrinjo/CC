<?php

declare(strict_types=1);

namespace App\Repository;

use App\Entity\Participant;
use App\Repository\Trait\EntityRepository;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Participant>
 *
 * @method Participant|null find($id, $lockMode = null, $lockVersion = null)
 * @method Participant|null findOneBy(mixed[] $criteria, mixed[] $orderBy = null)
 * @method Participant[]    findAll()
 * @method Participant[]    findBy(mixed[] $criteria, mixed[] $orderBy = null, $limit = null, $offset = null)
 */
class ParticipantRepository extends ServiceEntityRepository
{
    /** @use EntityRepository<Participant> */
    use EntityRepository;

    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Participant::class);
    }
}
