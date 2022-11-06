<?php

declare(strict_types=1);

namespace App\Tests\Controller\Workshop;

use App\Repository\WorkshopRepository;
use App\Tests\ApiTestCase;

class DeleteControllerTest extends ApiTestCase
{
    public function test_it_should_delete_a_workshop(): void
    {
        $this->loadFixtures([
            __DIR__.'/fixtures/delete_workshop.yaml',
        ]);

        static::assertNotNull(
            static::getContainer()->get(WorkshopRepository::class)->findOneByIdentifier('bd5c7f16-576a-48ef-963b-c91b62e1942b')
        );

        $this->browser->request('DELETE', '/workshops/bd5c7f16-576a-48ef-963b-c91b62e1942b', [], [], ['HTTP_Authorization' => 'Bearer '.$this->getAdminToken()]);

        static::assertNull(
            static::getContainer()->get(WorkshopRepository::class)->findOneByIdentifier('bd5c7f16-576a-48ef-963b-c91b62e1942b')
        );
    }
}
