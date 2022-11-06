<?php

declare(strict_types=1);

namespace App\Controller\Attendee;

use App\Entity\Attendee;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\SerializerInterface;

#[Route('/attendees/{identifier}', name: 'read_attendee', methods: ['GET'])]
final class ReadController
{
    public function __construct(
        private SerializerInterface $serializer,
    ) {
    }

    public function __invoke(Attendee $attendee): Response
    {
        $serializedAttendee = $this->serializer->serialize($attendee, 'json');

        return new Response($serializedAttendee, Response::HTTP_OK, [
            'Content-Type' => 'application/json',
        ]);
    }
}
