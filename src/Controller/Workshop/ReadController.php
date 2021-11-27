<?php

declare(strict_types=1);

namespace App\Controller\Workshop;

use App\Entity\Workshop;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/workshops/{identifier}', name: 'read_workshop', methods: ['GET'])]
final class ReadController
{
    public function __invoke(Workshop $workshop): Response
    {
        return new Response(json_encode($workshop->toArray()), Response::HTTP_OK, [
            'Content-Type' => 'application/json',
        ]);
    }
}
