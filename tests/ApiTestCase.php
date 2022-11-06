<?php

declare(strict_types=1);

namespace App\Tests;

use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\Tools\SchemaTool;
use Spatie\Snapshots\MatchesSnapshots;
use Symfony\Bundle\FrameworkBundle\KernelBrowser;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class ApiTestCase extends WebTestCase
{
    use FixtureLoadTrait;
    use MatchesSnapshots;

    protected KernelBrowser $browser;
    protected EntityManagerInterface $entityManager;

    protected function setUp(): void
    {
        $this->browser = static::createClient();

        $this->entityManager = static::getContainer()->get('doctrine.orm.default_entity_manager');

        $schemaTool = new SchemaTool($this->entityManager);
        $schemaTool->dropSchema($this->entityManager->getMetadataFactory()->getAllMetadata());
        $schemaTool->createSchema($this->entityManager->getMetadataFactory()->getAllMetadata());
    }

    protected function getUserToken(): string
    {
        $this->browser->request('POST', '/token', [], [], [
            'PHP_AUTH_USER' => 'api_user',
            'PHP_AUTH_PW' => 'api_user',
        ]);

        return json_decode($this->browser->getResponse()->getContent(), true)['token'];
    }

    protected function getAdminToken(): string
    {
        $this->browser->request('POST', '/token', [], [], [
            'PHP_AUTH_USER' => 'api_admin',
            'PHP_AUTH_PW' => 'api_admin',
        ]);

        return json_decode($this->browser->getResponse()->getContent(), true)['token'];
    }
}
