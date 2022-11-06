<?php

declare(strict_types=1);

namespace App\Tests\Controller\Workshop;

use App\Entity\Workshop;
use App\Repository\WorkshopRepository;
use App\Tests\ApiTestCase;

class AddAttendeeToWorkshopControllerTest extends ApiTestCase
{
    public function test_it_should_add_an_attendee_to_a_workshop(): void
    {
        $this->loadFixtures([
            __DIR__.'/fixtures/add_attendee_to_workshop.yaml',
        ]);

        /** @var Workshop $workshop */
        $workshop = static::getContainer()->get(WorkshopRepository::class)->findOneByIdentifier('e5444459-db7f-42a8-9a93-7925d4ffd1dc');
        static::assertCount(0, $workshop->getAttendees());

        $this->browser->request('POST', '/workshops/e5444459-db7f-42a8-9a93-7925d4ffd1dc/attendees/add/e9a95edb-9b49-42f4-bf2d-7206fd65bc94', [], [], []);

        static::assertResponseStatusCodeSame(204);

        /** @var Workshop $workshop */
        $workshop = static::getContainer()->get(WorkshopRepository::class)->findOneByIdentifier('e5444459-db7f-42a8-9a93-7925d4ffd1dc');
        static::assertCount(1, $workshop->getAttendees());
        static::assertSame('e9a95edb-9b49-42f4-bf2d-7206fd65bc94', $workshop->getAttendees()[0]->getIdentifier());
    }
}
