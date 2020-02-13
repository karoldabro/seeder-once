<?php

namespace Kdabrow\SeederOnce\Tests\Integration\Repositories;

use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Schema;
use Kdabrow\SeederOnce\Contracts\SeederOnceRepositoryInterface;
use Kdabrow\SeederOnce\Tests\TestCase;

class SeederRepositoryTest extends TestCase
{
    /**
     * @var SeederOnceRepositoryInterface
     */
    private $repository;

    public function setUp(): void
    {
        parent::setUp();

        $this->repository = resolve(SeederOnceRepositoryInterface::class);
    }

    public function test_if_repository_implements_interface()
    {
        $this->assertInstanceOf(SeederOnceRepositoryInterface::class, $this->repository);
    }

    public function test_if_repository_creates_seeders_table()
    {
        $this->repository->createTable();

        $this->assertTrue(Schema::hasTable(config('seederonce.table_name')));
    }

    public function test_if_check_of_existence_table_returns_true_when_table_exists()
    {
        $this->repository->createTable();

        $this->assertTrue($this->repository->existsTable());
    }

    public function test_if_check_of_existence_table_returns_false_when_table_not_exists()
    {
        $this->assertFalse($this->repository->existsTable());
    }

    public function test_if_add_method_adds_to_db()
    {
        $this->repository->createTable();

        $this->repository->add("seeder_name");

        $this->assertDatabaseHas(config('seederonce.table_name'), [
            'id' => 1,
            'name' => 'seeder_name',
        ]);
    }

    public function test_if_all_returns_collection()
    {
        $this->repository->createTable();

        $this->assertInstanceOf(Collection::class, $this->repository->all());
    }

    public function test_if_all_collection_is_empty_is_table_is_empty()
    {
        $this->repository->createTable();

        $this->assertTrue($this->repository->all()->isEmpty());
    }

    public function test_if_all_collection_has_all_data()
    {
        $this->repository->createTable();

        $this->repository->add("seeder_name");
        $this->repository->add("seeder_name_2");
        $this->repository->add("seeder_name_3");

        $all = $this->repository->all();

        $this->assertEquals(3, $all->count());

        $this->assertTrue($all->contains("name", "=", "seeder_name"));
        $this->assertTrue($all->contains("name", "=", "seeder_name_2"));
        $this->assertTrue($all->contains("name", "=", "seeder_name_3"));
    }

    public function test_if_method_is_done_will_return_true_when_seed_is_in_db()
    {
        $this->repository->createTable();

        $this->repository->add("seeder_name");

        $this->assertTrue($this->repository->isDone("seeder_name"));
    }

    public function test_if_method_is_done_will_return_false_is_seed_was_not_done()
    {
        $this->repository->createTable();

        $this->repository->add("seeder_name");

        $this->assertFalse($this->repository->isDone("seeder_name_2"));
    }
}
