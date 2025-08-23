<?php

declare(strict_types=1);

namespace App\Repository;

use App\Entity\Gear;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Gear>
 *
 * @method Gear|null find($id, $lockMode = null, $lockVersion = null)
 * @method Gear|null findOneBy(mixed[] $criteria, mixed[] $orderBy = null)
 * @method Gear[]    findAll()
 * @method Gear[]    findBy(mixed[] $criteria, mixed[] $orderBy = null, $limit = null, $offset = null)
 */
class GearRepository extends ServiceEntityRepository
{

    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Gear::class);
    }

}
