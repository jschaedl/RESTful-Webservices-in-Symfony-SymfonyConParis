<?php

declare(strict_types=1);

namespace App\Controller\Attendee;

use App\Entity\Attendee;
use App\Repository\AttendeeRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/attendees', name: 'list_attendee', methods: ['GET'])]
final class ListController
{
    public function __construct(
        private AttendeeRepository $attendeeRepository
    ) {
    }

    public function __invoke(): Response
    {
        $allAttendees = $this->attendeeRepository->findAll();

        $allAttendeesAsArray = array_map(
            static fn (Attendee $attendee) => $attendee->toArray(),
            $allAttendees
        );

        return new Response(json_encode($allAttendeesAsArray), Response::HTTP_OK, [
            'Content-Type' => 'application/json',
        ]);
    }
}
