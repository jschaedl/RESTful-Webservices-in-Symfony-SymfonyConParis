<?php

declare(strict_types=1);

namespace App\Controller\Attendee;

use App\Domain\AttendeeUpdater;
use App\Domain\Model\UpdateAttendeeModel;
use App\Entity\Attendee;
use OpenApi\Annotations as OA;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[IsGranted('ROLE_USER')]
#[Route('/attendees/{identifier}', name: 'update_attendee', methods: ['PUT'])]
final class UpdateController
{
    public function __construct(
        private AttendeeUpdater $attendeeUpdater,
    ) {
    }

    /**
     * @OA\Put(
     *     tags={"Attendee"},
     *     deprecated=true,
     *     description="This endpoint is deprecated, please don't rely on it anymore."
     * )
     */
    public function __invoke(Request $request, Attendee $attendee, UpdateAttendeeModel $updateAttendeeModel)
    {
        $this->attendeeUpdater->update($attendee, $updateAttendeeModel);

        return new Response(null, Response::HTTP_NO_CONTENT, [
            'Sunset' => (new \DateTime())->modify('+ 1 year')->format(DATE_RFC7231), // HTTP Date by RFC 7231
        ]);
    }
}
