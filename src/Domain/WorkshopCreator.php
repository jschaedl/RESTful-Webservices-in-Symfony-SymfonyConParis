<?php

declare(strict_types=1);

namespace App\Domain;

use App\Domain\Model\CreateWorkshopModel;
use App\Entity\Workshop;
use Doctrine\ORM\EntityManagerInterface;
use Ramsey\Uuid\Uuid;

final class WorkshopCreator
{
    public function __construct(
        private EntityManagerInterface $entityManager,
    ) {
    }

    public function create(CreateWorkshopModel $createWorkshopModel): Workshop
    {
        $newWorkshop = new Workshop(
            Uuid::uuid4()->toString(),
            $createWorkshopModel->title,
            \DateTimeImmutable::createFromFormat('Y-m-d', $createWorkshopModel->workshopDate),
        );

        $this->entityManager->persist($newWorkshop);
        $this->entityManager->flush();

        return $newWorkshop;
    }
}
