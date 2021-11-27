<?php

declare(strict_types=1);

namespace App\Controller\Workshop;

use App\Domain\Model\UpdateWorkshopModel;
use App\Domain\WorkshopUpdater;
use App\Entity\Workshop;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/workshops/{identifier}', name: 'update_workshop', methods: ['PUT'])]
final class UpdateController
{
    public function __construct(
        private WorkshopUpdater $workshopUpdater,
    ) {
    }

    public function __invoke(Request $request, Workshop $workshop, UpdateWorkshopModel $updateWorkshopModel)
    {
        $this->workshopUpdater->update($workshop, $updateWorkshopModel);

        return new Response(null, Response::HTTP_NO_CONTENT);
    }
}
