<?php

declare(strict_types=1);

namespace App\Controller\Workshop;

use App\Entity\Workshop;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\SerializerInterface;

#[Route('/workshops/{identifier}', name: 'read_workshop', methods: ['GET'])]
final class ReadController
{
    public function __construct(
        private SerializerInterface $serializer,
    ) {
    }

    public function __invoke(Workshop $workshop): Response
    {
        $serializedWorkshop = $this->serializer->serialize($workshop, 'json');

        return new Response($serializedWorkshop, Response::HTTP_OK, [
            'Content-Type' => 'application/json',
        ]);
    }
}
