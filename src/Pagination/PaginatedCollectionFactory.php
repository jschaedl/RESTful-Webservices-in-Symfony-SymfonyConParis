<?php

declare(strict_types=1);

namespace App\Pagination;

use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepositoryInterface;
use Doctrine\ORM\Tools\Pagination\Paginator;

abstract class PaginatedCollectionFactory
{
    abstract public function getRepository(): ServiceEntityRepositoryInterface;

    public function create(int $page, int $size): PaginatedCollection
    {
        $query = $this->getRepository()
            ->createQueryBuilder('u')
            ->orderBy('u.id', 'asc')
            ->getQuery()
        ;

        $paginator = new Paginator($query);
        $total = count($paginator);

        $paginator
            ->getQuery()
            ->setFirstResult($size * ($page - 1))
            ->setMaxResults($size);

        return new PaginatedCollection($paginator->getIterator(), $total);
    }
}
