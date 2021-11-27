<?php

declare(strict_types=1);

namespace App\Controller\Attendee;

use App\Repository\AttendeeRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\SerializerInterface;

#[Route('/attendees', name: 'list_attendee', methods: ['GET'])]
final class ListController
{
    public function __construct(
        private AttendeeRepository $attendeeRepository,
        private SerializerInterface $serializer,
    ) {
    }

    public function __invoke(): Response
    {
        $allAttendees = $this->attendeeRepository->findAll();

        $serializedAttendees = $this->serializer->serialize($allAttendees, 'json');

        return new Response($serializedAttendees, Response::HTTP_OK, [
            'Content-Type' => 'application/json',
        ]);
    }
}
