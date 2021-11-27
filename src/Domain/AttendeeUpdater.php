<?php

declare(strict_types=1);

namespace App\Domain;

use App\Domain\Model\UpdateAttendeeModel;
use App\Entity\Attendee;
use Doctrine\ORM\EntityManagerInterface;

final class AttendeeUpdater
{
    public function __construct(
        private EntityManagerInterface $entityManager,
    ) {
    }

    public function update(Attendee $attendee, UpdateAttendeeModel $createAttendeeModel): Attendee
    {
        if ($firstname = $createAttendeeModel->firstname) {
            $attendee->updateFirstname($firstname);
        }

        if ($lastname = $createAttendeeModel->lastname) {
            $attendee->updateLastname($lastname);
        }

        if ($email = $createAttendeeModel->email) {
            $attendee->updateEmail($email);
        }

        $this->entityManager->flush();

        return $attendee;
    }
}
