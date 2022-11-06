<?php

declare(strict_types=1);

namespace App\Controller\Attendee;

use App\Pagination\AttendeeCollectionFactory;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\SerializerInterface;

#[Route('/attendees', name: 'list_attendee', methods: ['GET'])]
final class ListController
{
    public function __construct(
        private AttendeeCollectionFactory $attendeeCollectionFactory,
        private SerializerInterface $serializer,
    ) {
    }

    public function __invoke(Request $request): Response
    {
        $attendeeCollection = $this->attendeeCollectionFactory->create(
            $request->query->getInt('page', 1),
            $request->query->getInt('size', 10)
        );

        $serializedAttendeeCollection = $this->serializer->serialize($attendeeCollection, 'json');

        return new Response($serializedAttendeeCollection, Response::HTTP_OK, [
            'Content-Type' => 'application/json',
        ]);
    }
}
