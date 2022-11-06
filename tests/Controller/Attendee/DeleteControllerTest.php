<?php

declare(strict_types=1);

namespace App\Tests\Controller\Attendee;

use App\Repository\AttendeeRepository;
use App\Tests\ApiTestCase;

class DeleteControllerTest extends ApiTestCase
{
    public function test_it_should_delete_an_attendee(): void
    {
        $this->loadFixtures([
            __DIR__.'/fixtures/delete_attendee.yaml',
        ]);

        static::assertNotNull(
            static::getContainer()->get(AttendeeRepository::class)->findOneByIdentifier('bb5cb8a8-0df8-404f-a3f3-54ee5c9cf855')
        );

        $this->browser->request('DELETE', '/attendees/bb5cb8a8-0df8-404f-a3f3-54ee5c9cf855');

        static::assertNull(
            static::getContainer()->get(AttendeeRepository::class)->findOneByIdentifier('bb5cb8a8-0df8-404f-a3f3-54ee5c9cf855')
        );
    }
}
