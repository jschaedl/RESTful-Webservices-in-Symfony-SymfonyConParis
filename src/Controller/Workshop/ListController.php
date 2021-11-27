<?php

declare(strict_types=1);

namespace App\Controller\Workshop;

use App\Repository\WorkshopRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\SerializerInterface;

#[Route('/workshops', name: 'list_workshop', methods: ['GET'])]
final class ListController
{
    public function __construct(
        private WorkshopRepository $workshopRepository,
        private SerializerInterface $serializer,
    ) {
    }

    public function __invoke(): Response
    {
        $allWorkshops = $this->workshopRepository->findAll();

        $serializedWorkshops = $this->serializer->serialize($allWorkshops, 'json');

        return new Response($serializedWorkshops, Response::HTTP_OK, [
            'Content-Type' => 'application/json',
        ]);
    }
}
