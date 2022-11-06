<?php

declare(strict_types=1);

namespace App\Tests\Controller\Attendee;

use App\Entity\Attendee;
use App\Repository\AttendeeRepository;
use App\Tests\ApiTestCase;

class UpdateControllerTest extends ApiTestCase
{
    public function test_it_should_update_an_attendee(): void
    {
        $this->loadFixtures([
            __DIR__.'/fixtures/update_attendee.yaml',
        ]);

        $attendeesBefore = static::getContainer()->get(AttendeeRepository::class)->findAll();
        static::assertCount(1, $attendeesBefore);

        $this->browser->request('PUT', '/attendees/b38aa3e4-f9de-4dca-aaeb-3ec36a9feb6c', [], [], [],
            <<<'EOT'
{
    "firstname": "Paul",
	"lastname": "Paulsen",
	"email": "paul@paulsen.de"
}
EOT
        );

        static::assertResponseStatusCodeSame(204);

        $attendeesAfter = static::getContainer()->get(AttendeeRepository::class)->findAll();
        static::assertCount(1, $attendeesAfter);

        /** @var Attendee $expectedAttendee */
        $expectedAttendee = $attendeesAfter[0];
        static::assertSame('Paul', $expectedAttendee->getFirstname());
        static::assertSame('Paulsen', $expectedAttendee->getLastname());
        static::assertSame('paul@paulsen.de', $expectedAttendee->getEmail());
    }

    /**
     * @dataProvider provideUnprocessableAttendeeData
     */
    public function test_it_should_return_proper_errors(string $requestBody): void
    {
        $this->loadFixtures([
            __DIR__.'/fixtures/update_attendee.yaml',
        ]);

        $attendeesBefore = static::getContainer()->get(AttendeeRepository::class)->findAll();
        static::assertCount(1, $attendeesBefore);

        $this->browser->request('PUT', '/attendees/b38aa3e4-f9de-4dca-aaeb-3ec36a9feb6c', [], [], [], $requestBody);

        static::assertResponseStatusCodeSame(422);

        $this->assertMatchesJsonSnapshot($this->browser->getResponse()->getContent());
    }

    public function provideUnprocessableAttendeeData(): \Generator
    {
        yield 'no data' => [''];
        yield 'wrong json one' => ['{'];
        yield 'wrong json two' => ['}'];
        yield 'wrong email' => ['{"email": "paulpaulsende"}'];
    }
}
