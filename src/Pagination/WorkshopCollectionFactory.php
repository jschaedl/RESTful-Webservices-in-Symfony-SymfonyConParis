<?php

declare(strict_types=1);

namespace App\Pagination;

use App\Repository\WorkshopRepository;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepositoryInterface;

final class WorkshopCollectionFactory extends PaginatedCollectionFactory
{
    public function __construct(
        private WorkshopRepository $workshopRepository
    ) {
    }

    public function getRepository(): ServiceEntityRepositoryInterface
    {
        return $this->workshopRepository;
    }
}
