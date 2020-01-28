<?php

namespace Kdabrow\SeederOnce\Tests\Unit\Repositories;

use Kdabrow\SeederOnce\Contracts\SeederRepositoryInterface;
use Kdabrow\SeederOnce\Repositories\SeederRepository;
use Kdabrow\SeederOnce\Seeder;
use Kdabrow\SeederOnce\Tests\TestCase;

class SeederRepositoryTest extends TestCase
{
    public function setUp(): void
    {
        parent::setUp();

        $this->loadMigrationsFrom(__DIR__ . '../database/migrations');
    }

    public function test_if_repository_implements_interface()
    {
        $repository = new SeederRepository();

        $this->assertInstanceOf(SeederRepositoryInterface::class, $repository);
    }

    public function test_if_add_method_adds_to_db()
    {
        $repository = new SeederRepository();

        $repository->add("seeder_name");

        $result = Seeder::where('seeder', '=', 'seeder_name')->first();

        $this->assertNotNull($result);
    }
}
