<?php

declare(strict_types=1);

namespace App\Tests\Controller\Workshop;

use App\Tests\ApiTestCase;

class ListControllerTest extends ApiTestCase
{
    public function test_it_should_list_all_workshops(): void
    {
        $this->loadFixtures([
            __DIR__.'/fixtures/list_workshop.yaml',
        ]);

        $this->browser->request('GET', '/workshops');

        static::assertResponseIsSuccessful();

        $this->assertMatchesJsonSnapshot($this->browser->getResponse()->getContent());
    }
}
