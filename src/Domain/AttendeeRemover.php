<?php

declare(strict_types=1);

namespace App\Domain;

use App\Entity\Attendee;
use Doctrine\ORM\EntityManagerInterface;

final class AttendeeRemover
{
    public function __construct(
        private EntityManagerInterface $entityManager,
    ) {
    }

    public function remove(Attendee $attendee): void
    {
        $this->entityManager->remove($attendee);
        $this->entityManager->flush();
    }
}
