<?php

declare(strict_types=1);

namespace App\Pagination;

use App\Negotiation\ContentNegotiator;
use App\Repository\WorkshopRepository;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepositoryInterface;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;

final class WorkshopCollectionFactory extends PaginatedCollectionFactory
{
    public function __construct(
        private WorkshopRepository $workshopRepository,
        UrlGeneratorInterface $urlGenerator,
        ContentNegotiator $contentNegotiator,
    ) {
        parent::__construct($urlGenerator, $contentNegotiator);
    }

    public function getRepository(): ServiceEntityRepositoryInterface
    {
        return $this->workshopRepository;
    }

    public function getRouteName(): string
    {
        return 'list_workshop';
    }
}
