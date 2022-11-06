<?php

declare(strict_types=1);

namespace App\Controller\Workshop;

use App\Entity\Attendee;
use App\Entity\Workshop;
use Doctrine\ORM\EntityManagerInterface;
use OpenApi\Annotations as OA;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Entity;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[IsGranted('ROLE_USER')]
#[Route('/workshops/{identifier}/attendees/remove/{attendee_identifier}', name: 'remove_attendee_from_workshop', methods: ['POST'])]
#[Entity('attendee', expr: 'repository.findOneByIdentifier(attendee_identifier)')]
class RemoveAttendeeFromWorkshopController
{
    public function __construct(
        private EntityManagerInterface $entityManager
    ) {
    }

    /**
     * @OA\Post(tags={"Workshop"})
     */
    public function __invoke(Request $request, Workshop $workshop, Attendee $attendee)
    {
        $workshop->removeAttendee($attendee);

        $this->entityManager->flush();

        return new Response(null, Response::HTTP_NO_CONTENT);
    }
}
