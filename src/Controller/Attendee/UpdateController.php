<?php

declare(strict_types=1);

namespace App\Controller\Attendee;

use App\Domain\AttendeeUpdater;
use App\Domain\Model\UpdateAttendeeModel;
use App\Entity\Attendee;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/attendees/{identifier}', name: 'update_attendee', methods: ['PUT'])]
final class UpdateController
{
    public function __construct(
        private AttendeeUpdater $attendeeUpdater,
    ) {
    }

    public function __invoke(Request $request, Attendee $attendee, UpdateAttendeeModel $updateAttendeeModel)
    {
        $this->attendeeUpdater->update($attendee, $updateAttendeeModel);

        return new Response(null, Response::HTTP_NO_CONTENT);
    }
}
