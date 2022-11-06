<?php

declare(strict_types=1);

namespace App\Controller\Workshop;

use App\Pagination\WorkshopCollectionFactory;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\SerializerInterface;

#[Route('/workshops', name: 'list_workshop', methods: ['GET'])]
final class ListController
{
    public function __construct(
        private WorkshopCollectionFactory $workshopCollectionFactory,
        private SerializerInterface $serializer,
    ) {
    }

    public function __invoke(Request $request): Response
    {
        $workshopCollection = $this->workshopCollectionFactory->create(
            $request->query->getInt('page', 1),
            $request->query->getInt('size', 10)
        );

        $serializedWorkshopCollection = $this->serializer->serialize($workshopCollection, 'json');

        return new Response($serializedWorkshopCollection, Response::HTTP_OK, [
            'Content-Type' => 'application/json',
        ]);
    }
}
