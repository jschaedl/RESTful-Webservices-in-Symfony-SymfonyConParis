<?php

declare(strict_types=1);

namespace App\Tests;

trait FixtureLoadTrait
{
    public function loadFixtures(array $fixtures): array
    {
        return static::getContainer()->get('fidry_alice_data_fixtures.loader.doctrine')->load($fixtures);
    }

    public function appendFixtures(array $fixtures): array
    {
        return static::getContainer()->get('fidry_alice_data_fixtures.doctrine.persister_loader')->load($fixtures);
    }
}
