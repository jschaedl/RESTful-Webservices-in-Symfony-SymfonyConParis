<?php

declare(strict_types=1);

namespace App\Tests\Controller\Attendee;

use App\Entity\Attendee;
use App\Repository\AttendeeRepository;
use App\Tests\ApiTestCase;

class CreateControllerTest extends ApiTestCase
{
    public function test_it_should_create_an_attendee(): void
    {
        $attendeesBefore = static::getContainer()->get(AttendeeRepository::class)->findAll();
        static::assertCount(0, $attendeesBefore);

        $this->browser->request('POST', '/attendees', [], [], [],
            <<<'EOT'
{
    "firstname": "Paul",
	"lastname": "Paulsen",
	"email": "paul@paulsen.de"
}
EOT
        );

        static::assertResponseStatusCodeSame(201);
        static::assertResponseHasHeader('Content-Type');
        static::assertResponseHasHeader('Location');

        $attendeesAfter = static::getContainer()->get(AttendeeRepository::class)->findAll();
        static::assertCount(1, $attendeesAfter);

        /** @var Attendee $expectedAttendee */
        $expectedAttendee = $attendeesAfter[0];
        static::assertSame('Paul', $expectedAttendee->getFirstname());
        static::assertSame('Paulsen', $expectedAttendee->getLastname());
        static::assertSame('paul@paulsen.de', $expectedAttendee->getEmail());
    }
}
