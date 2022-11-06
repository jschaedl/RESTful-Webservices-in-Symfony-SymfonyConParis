<?php

declare(strict_types=1);

namespace App\Tests\Controller\Attendee;

use App\Tests\ApiTestCase;

class ListControllerTest extends ApiTestCase
{
    public function test_it_should_list_all_attendees(): void
    {
        $this->loadFixtures([
            __DIR__.'/fixtures/list_attendee.yaml',
        ]);

        $this->browser->request('GET', '/attendees');

        static::assertResponseIsSuccessful();

        $this->assertMatchesJsonSnapshot($this->browser->getResponse()->getContent());
    }
}
