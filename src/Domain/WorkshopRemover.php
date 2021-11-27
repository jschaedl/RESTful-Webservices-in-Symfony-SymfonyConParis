<?php

declare(strict_types=1);

namespace App\Domain;

use App\Entity\Workshop;
use Doctrine\ORM\EntityManagerInterface;

final class WorkshopRemover
{
    public function __construct(
        private EntityManagerInterface $entityManager,
    ) {
    }

    public function remove(Workshop $workshop): void
    {
        $this->entityManager->remove($workshop);
        $this->entityManager->flush();
    }
}
