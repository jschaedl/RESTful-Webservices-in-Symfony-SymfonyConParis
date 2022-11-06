<?php

declare(strict_types=1);

namespace App\Tests\Controller\Workshop;

use App\Entity\Workshop;
use App\Repository\WorkshopRepository;
use App\Tests\ApiTestCase;

class RemoveAttendeeToWorkshopControllerTest extends ApiTestCase
{
    public function test_it_should_add_an_attendee_to_a_workshop(): void
    {
        $this->loadFixtures([
            __DIR__.'/fixtures/remove_attendee_to_workshop.yaml',
        ]);

        /** @var Workshop $workshop */
        $workshop = static::getContainer()->get(WorkshopRepository::class)->findOneByIdentifier('667731df-0a66-4030-9589-e8ab850a209b');
        static::assertCount(1, $workshop->getAttendees());

        $this->browser->request('POST', '/workshops/667731df-0a66-4030-9589-e8ab850a209b/attendees/remove/f6ac0c74-ca77-4b3b-9829-8c0cfe29cf44', [], [], []);

        static::assertResponseStatusCodeSame(204);

        /** @var Workshop $workshop */
        $workshop = static::getContainer()->get(WorkshopRepository::class)->findOneByIdentifier('667731df-0a66-4030-9589-e8ab850a209b');
        static::assertCount(0, $workshop->getAttendees());
    }
}
