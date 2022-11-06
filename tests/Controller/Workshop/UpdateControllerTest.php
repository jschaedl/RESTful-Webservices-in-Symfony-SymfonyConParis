<?php

declare(strict_types=1);

namespace App\Tests\Controller\Workshop;

use App\Entity\Workshop;
use App\Repository\WorkshopRepository;
use App\Tests\ApiTestCase;

class UpdateControllerTest extends ApiTestCase
{
    public function test_it_should_update_an_workshop(): void
    {
        $this->loadFixtures([
            __DIR__.'/fixtures/update_workshop.yaml',
        ]);

        $workshopsBefore = static::getContainer()->get(WorkshopRepository::class)->findAll();
        static::assertCount(1, $workshopsBefore);

        $this->browser->request('PUT', '/workshops/74857cb7-ff9e-4976-87e5-168438c3c53e', [], [], ['HTTP_Authorization' => 'Bearer '.$this->getUserToken()],
            <<<'EOT'
{
    "title": "Test Workshop",
	"workshop_date": "2021-12-08"
}
EOT
        );

        static::assertResponseStatusCodeSame(204);

        $workshopsAfter = static::getContainer()->get(WorkshopRepository::class)->findAll();
        static::assertCount(1, $workshopsAfter);

        /** @var Workshop $expectedWorkshop */
        $expectedWorkshop = $workshopsAfter[0];
        static::assertSame('Test Workshop', $expectedWorkshop->getTitle());
        static::assertSame('2021-12-08', $expectedWorkshop->getWorkshopDate()->format('Y-m-d'));
    }

    /**
     * @dataProvider provideUnprocessableWorkshopData
     */
    public function test_it_should_return_proper_errors(string $requestBody): void
    {
        $this->loadFixtures([
            __DIR__.'/fixtures/update_workshop.yaml',
        ]);

        $workshopsBefore = static::getContainer()->get(WorkshopRepository::class)->findAll();
        static::assertCount(1, $workshopsBefore);

        $this->browser->request('PUT', '/workshops/74857cb7-ff9e-4976-87e5-168438c3c53e', [], [], ['HTTP_Authorization' => 'Bearer '.$this->getUserToken()], $requestBody);

        static::assertResponseStatusCodeSame(422);

        $this->assertMatchesJsonSnapshot($this->browser->getResponse()->getContent());
    }

    public function provideUnprocessableWorkshopData(): \Generator
    {
        yield 'no data' => [''];
        yield 'wrong json one' => ['{'];
        yield 'wrong json two' => ['}'];
        yield 'wrong workshopDate' => ['{"title": "Test Workshop", "workshop_date": "2021-bla-blub"}'];
    }
}
