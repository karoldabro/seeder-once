<?php

namespace Kdabrow\SeederOnce\Tests\Integration\Repositories;

use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Schema;
use Kdabrow\SeederOnce\Contracts\SeederRepositoryInterface;
use Kdabrow\SeederOnce\Tests\TestCase;

class SeederRepositoryTest extends TestCase
{
    public function setUp(): void
    {
        parent::setUp();
    }

    public function test_if_repository_implements_interface()
    {
        $repository = resolve(SeederRepositoryInterface::class);

        $this->assertInstanceOf(SeederRepositoryInterface::class, $repository);
    }

    public function test_if_repository_creates_seeders_table()
    {
        $repository = resolve(SeederRepositoryInterface::class);
        $repository->createTable();

        $this->assertTrue(Schema::hasTable(config('seederonce.table_name')));
    }

    public function test_if_check_of_existence_table_returns_true_when_table_exists()
    {
        $repository = resolve(SeederRepositoryInterface::class);
        $repository->createTable();

        $this->assertTrue($repository->existsTable());
    }

    public function test_if_check_of_existence_table_returns_false_when_table_not_exists()
    {
        $repository = resolve(SeederRepositoryInterface::class);

        $this->assertFalse($repository->existsTable());
    }

    public function test_if_add_method_adds_to_db()
    {
        $repository = resolve(SeederRepositoryInterface::class);
        $repository->createTable();

        $repository->add("seeder_name", 1);

        $this->assertDatabaseHas(config('seederonce.table_name'), [
            'id' => 1,
            'name' => 'seeder_name',
        ]);
    }

    public function test_if_all_returns_collection()
    {
        $repository = resolve(SeederRepositoryInterface::class);
        $repository->createTable();

        $this->assertInstanceOf(Collection::class, $repository->all());
    }

    public function test_if_all_collection_is_empty_is_table_is_empty()
    {
        $repository = resolve(SeederRepositoryInterface::class);
        $repository->createTable();

        $this->assertTrue($repository->all()->isEmpty());
    }

    public function test_if_all_collection_has_all_data()
    {
        $repository = resolve(SeederRepositoryInterface::class);
        $repository->createTable();

        $repository->add("seeder_name", 1);
        $repository->add("seeder_name_2", 1);
        $repository->add("seeder_name_3", 1);

        $all = $repository->all();

        $this->assertEquals(3, $all->count());

        $this->assertTrue($all->contains("name", "=", "seeder_name"));
        $this->assertTrue($all->contains("name", "=", "seeder_name_2"));
        $this->assertTrue($all->contains("name", "=", "seeder_name_3"));
    }
}
