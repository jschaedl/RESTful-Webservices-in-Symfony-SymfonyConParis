<?php

declare(strict_types=1);

namespace App\Repository;

use App\Entity\Attendee;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Attendee|null find($id, $lockMode = null, $lockVersion = null)
 * @method Attendee|null findOneBy(array $criteria, array $orderBy = null)
 * @method Attendee[]    findAll()
 * @method Attendee[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class AttendeeRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Attendee::class);
    }
}
