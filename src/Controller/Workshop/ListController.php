<?php

declare(strict_types=1);

namespace App\Controller\Workshop;

use App\Entity\Workshop;
use App\Repository\WorkshopRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/workshops', name: 'list_workshop', methods: ['GET'])]
final class ListController
{
    public function __construct(
        private WorkshopRepository $workshopRepository
    ) {
    }

    public function __invoke(): Response
    {
        $allWorkshops = $this->workshopRepository->findAll();

        $allWorkshopsAsArray = array_map(
            static fn (Workshop $workshop) => $workshop->toArray(),
            $allWorkshops
        );

        return new Response(json_encode($allWorkshopsAsArray), Response::HTTP_OK, [
            'Content-Type' => 'application/json',
        ]);
    }
}
