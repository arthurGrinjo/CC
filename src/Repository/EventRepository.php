<?php

declare(strict_types=1);

namespace App\Repository;

use App\Entity\Event;
use App\Repository\Trait\EntityRepository;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Event>
 *
 * @method Event|null find($id, $lockMode = null, $lockVersion = null)
 * @method Event|null findOneBy(mixed[] $criteria, mixed[] $orderBy = null)
 * @method Event[]    findAll()
 * @method Event[]    findBy(mixed[] $criteria, mixed[] $orderBy = null, $limit = null, $offset = null)
 */
class EventRepository extends ServiceEntityRepository
{
    /** @use EntityRepository<Event> */
    use EntityRepository;

    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Event::class);
    }

}