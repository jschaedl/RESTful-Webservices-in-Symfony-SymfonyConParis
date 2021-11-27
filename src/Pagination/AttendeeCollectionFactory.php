<?php

declare(strict_types=1);

namespace App\Pagination;

use App\Repository\AttendeeRepository;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepositoryInterface;

final class AttendeeCollectionFactory extends PaginatedCollectionFactory
{
    public function __construct(
        private AttendeeRepository $attendeeRepository
    ) {
    }

    public function getRepository(): ServiceEntityRepositoryInterface
    {
        return $this->attendeeRepository;
    }
}
