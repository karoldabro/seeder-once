<?php

namespace Kdabrow\SeederOnce\Tests\Integration\Repositories;

use Illuminate\Support\Collection;
use Kdabrow\SeederOnce\Contracts\SeederRepositoryInterface;
use Kdabrow\SeederOnce\Repositories\SeederRepository;
use Kdabrow\SeederOnce\Models\Seeder;
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

    public function test_if_all_returns_collection()
    {
        $repository = new SeederRepository();

        $this->assertInstanceOf(Collection::class, $repository->all());
    }

    public function test_if_all_collection_is_empty_is_table_is_empty()
    {
        $repository = new SeederRepository();

        $this->assertTrue($repository->all()->isEmpty());
    }

    public function test_if_all_collection_has_all_data()
    {
        $repository = new SeederRepository();

        $repository->add("seeder_name");
        $repository->add("seeder_name_2");
        $repository->add("seeder_name_3");

        $all = $repository->all();

        $this->assertEquals(3, $all->count());

        $this->assertTrue($all->contains("seeder", "=", "seeder_name"));
        $this->assertTrue($all->contains("seeder", "=", "seeder_name_2"));
        $this->assertTrue($all->contains("seeder", "=", "seeder_name_3"));
    }
}
