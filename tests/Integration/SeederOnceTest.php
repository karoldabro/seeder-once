<?php

namespace Kdabrow\SeederOnce\Tests\Integration;

use Illuminate\Support\Facades\Schema;
use Kdabrow\SeederOnce\Tests\TestCase;
use Kdabrow\SeederOnce\Contracts\SeederOnceRepositoryInterface;
use Kdabrow\SeederOnce\Tests\Integration\Mocks\SeederUsingSeederOnceMock;
use Kdabrow\SeederOnce\Tests\Integration\Mocks\SeederNotUsingSeederOnceMock;
use Kdabrow\SeederOnce\Tests\Integration\Mocks\SeederNotUsingSeederOnceMockCallOther;
use Kdabrow\SeederOnce\Tests\Integration\Mocks\SeederUsingSeederOnceMockCallOther;

class SeederOnceTest extends TestCase
{
    public function test_is_seeder_once_will_detect_lack_of_table_in_db_and_create_one()
    {
        $mockClass = resolve(SeederUsingSeederOnceMock::class);

        $mockClass->__invoke();

        $this->assertTrue(Schema::hasTable(config('seederonce.table_name')));
    }

    public function test_if_seed_will_be_executed_when_table_exists()
    {
        $this->createTable();

        $mockClass = resolve(SeederUsingSeederOnceMock::class);

        $this->assertTrue($mockClass->__invoke());
    }

    public function test_if_seed_that_was_executed_will_not_be_seeded_once_more()
    {
        $this->createTable();

        $mockClass = resolve(SeederUsingSeederOnceMock::class);

        $mockClass->__invoke();

        $this->assertNull($mockClass->__invoke());
    }

    private function createTable()
    {
        $repository = resolve(SeederOnceRepositoryInterface::class);
        $repository->createTable();
    }

    public function test_if_seeder_normal_will_behave_as_usual()
    {
        $this->createTable();

        $mockClassWith = resolve(SeederUsingSeederOnceMock::class);

        $mockClassWith->__invoke();

        $mockClassWithout = resolve(SeederNotUsingSeederOnceMock::class);

        $this->assertTrue($mockClassWithout->__invoke());

        $this->assertTrue($mockClassWithout->__invoke());

        $this->assertTrue($mockClassWithout->__invoke());
    }

    public function test_if_seeder_once_can_not_call_many_times_other_seeders()
    {
        $this->createTable();

        $mockClassWithCall = resolve(SeederUsingSeederOnceMockCallOther::class);

        $this->assertTrue($mockClassWithCall->__invoke());

        $this->assertNull($mockClassWithCall->__invoke());
    }

    public function test_if_internal_called_seeders_once_can_not_be_called_again()
    {
        $this->createTable();

        $mockClassWithCall = resolve(SeederUsingSeederOnceMockCallOther::class);

        $mockClassWithCall->__invoke();

        $mockClassWith = resolve(SeederUsingSeederOnceMock::class);

        $this->assertNull($mockClassWith->__invoke());
    }

    public function test_if_internal_called_seeders_normal_can_be_called_again()
    {
        $this->createTable();

        $mockClassWithCall = resolve(SeederUsingSeederOnceMockCallOther::class);

        $mockClassWithCall->__invoke();

        $mockClassWithout = resolve(SeederNotUsingSeederOnceMock::class);

        $this->assertTrue($mockClassWithout->__invoke());
    }

    public function test_if_seeder_with_calls_without_seeder_once_can_be_called_many_times()
    {
        $this->createTable();

        $mockClassWithoutCall = resolve(SeederNotUsingSeederOnceMockCallOther::class);

        $this->assertTrue($mockClassWithoutCall->__invoke());

        $this->assertTrue($mockClassWithoutCall->__invoke());
    }

    public function test_if_seeder_normal_can_call_seeder_once_with_no_repeating()
    {
        $this->createTable();

        $mockClassWithoutCall = resolve(SeederNotUsingSeederOnceMockCallOther::class);

        $mockClassWithoutCall->__invoke();

        $mockClassWith = resolve(SeederUsingSeederOnceMock::class);

        $this->assertNull($mockClassWith->__invoke());
    }

    public function test_if_seeder_normal_can_call_seeder_normal_many_times()
    {
        $this->createTable();

        $mockClassWithoutCall = resolve(SeederNotUsingSeederOnceMockCallOther::class);

        $mockClassWithoutCall->__invoke();

        $mockClassWithout = resolve(SeederNotUsingSeederOnceMock::class);

        $this->assertTrue($mockClassWithout->__invoke());
    }
}
