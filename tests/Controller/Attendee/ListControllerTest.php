<?php

declare(strict_types=1);

namespace App\Tests\Controller\Attendee;

use App\Tests\ApiTestCase;

class ListControllerTest extends ApiTestCase
{
    public function provideHttpAcceptHeaderValues(): \Generator
    {
        yield 'json' => ['application/json'];
        yield 'hal+json' => ['application/hal+json'];
    }

    /**
     * @dataProvider provideHttpAcceptHeaderValues
     */
    public function test_it_should_list_all_attendees(string $httpAcceptHeaderValue): void
    {
        $this->loadFixtures([
            __DIR__.'/fixtures/list_attendee.yaml',
        ]);

        $this->browser->request('GET', '/attendees', [], [], [
            'HTTP_ACCEPT' => $httpAcceptHeaderValue,
        ]);

        static::assertResponseIsSuccessful();

        $this->assertMatchesJsonSnapshot($this->browser->getResponse()->getContent());
    }

    /**
     * @dataProvider paginationQueryParameterValues
     */
    public function test_it_should_paginate_attendees(int $page, int $size): void
    {
        $this->loadFixtures([
            __DIR__.'/fixtures/paginate_attendee.yaml',
        ]);

        $this->browser->request('GET', sprintf('/attendees?page=%d&size=%d', $page, $size), [], []);

        static::assertResponseIsSuccessful();

        $this->assertMatchesJsonSnapshot($this->browser->getResponse()->getContent());
    }

    public function paginationQueryParameterValues(): \Generator
    {
        yield 'show 1st page, 3 items each' => [1, 3];
        yield 'show 2nd page, 3 items each' => [2, 3];
        yield 'show 1st page, 5 items each' => [1, 5];
        yield 'show 2nd page, 5 items each' => [2, 5];
    }
}
