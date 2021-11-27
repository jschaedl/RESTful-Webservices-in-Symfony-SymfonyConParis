<?php

declare(strict_types=1);

namespace App\Tests\Controller\Workshop;

use App\Entity\Workshop;
use App\Repository\WorkshopRepository;
use App\Tests\ApiTestCase;

class CreateControllerTest extends ApiTestCase
{
    public function test_it_should_create_a_workshop(): void
    {
        $workshopsBefore = static::getContainer()->get(WorkshopRepository::class)->findAll();
        static::assertCount(0, $workshopsBefore);

        $this->browser->request('POST', '/workshops', [], [], ['HTTP_Authorization' => 'Bearer '.$this->getUserToken()],
            <<<'EOT'
{
    "title": "Test Workshop",
	"workshop_date": "2021-12-07"
}
EOT
        );

        static::assertResponseStatusCodeSame(201);
        static::assertResponseHasHeader('Content-Type');
        static::assertResponseHasHeader('Location');

        $workshopsAfter = static::getContainer()->get(WorkshopRepository::class)->findAll();
        static::assertCount(1, $workshopsAfter);

        /** @var Workshop $expectedWorkshop */
        $expectedWorkshop = $workshopsAfter[0];
        static::assertSame('Test Workshop', $expectedWorkshop->getTitle());
        static::assertSame('2021-12-07', $expectedWorkshop->getWorkshopDate()->format('Y-m-d'));
    }

    /**
     * @dataProvider provideUnprocessableAttendeeData
     */
    public function test_it_should_return_proper_errors(string $requestBody): void
    {
        $this->browser->request('POST', '/workshops', [], [], ['HTTP_Authorization' => 'Bearer '.$this->getUserToken()], $requestBody);

        static::assertResponseStatusCodeSame(422);

        $this->assertMatchesJsonSnapshot($this->browser->getResponse()->getContent());
    }

    public function provideUnprocessableAttendeeData(): \Generator
    {
        yield 'no data' => [''];
        yield 'empty data' => ['{}'];
        yield 'wrong json one' => ['{'];
        yield 'wrong json two' => ['}'];
        yield 'missing title' => ['{"workshop_date": "2021-12-07"}'];
        yield 'missing workshopDate' => ['{"title": "Test Workshop"}'];
        yield 'wrong workshopDate' => ['{"title": "Test Workshop", "workshop_date": "2021-bla-blub"}'];
    }
}
