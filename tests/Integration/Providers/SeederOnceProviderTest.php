<?php

namespace Kdabrow\SeederOnce\Tests\Integration\Repositories;

use Kdabrow\SeederOnce\Tests\TestCase;

class SeederOnceProviderTest extends TestCase
{
    public function setUp(): void
    {
        parent::setUp();

        $this->loadMigrationsFrom(__DIR__ . '../database/migrations');
    }
}
