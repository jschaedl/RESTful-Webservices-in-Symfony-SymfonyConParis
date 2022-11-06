<?php

declare(strict_types=1);

namespace App\Domain;

use App\Domain\Model\UpdateWorkshopModel;
use App\Entity\Workshop;
use Doctrine\ORM\EntityManagerInterface;

final class WorkshopUpdater
{
    public function __construct(
        private EntityManagerInterface $entityManager,
    ) {
    }

    public function update(Workshop $workshop, UpdateWorkshopModel $updateWorkshopModel): Workshop
    {
        if ($title = $updateWorkshopModel->title) {
            $workshop->updateTitle($title);
        }

        if ($workshopDate = $updateWorkshopModel->workshopDate) {
            $workshop->updateWorkshopDate(\DateTimeImmutable::createFromFormat('Y-m-d', $workshopDate));
        }

        $this->entityManager->flush();

        return $workshop;
    }
}
