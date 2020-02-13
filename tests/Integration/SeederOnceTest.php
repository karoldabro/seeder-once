<?php

namespace Kdabrow\SeederOnce\Tests\Integration;

use Kdabrow\SeederOnce\Contracts\SeederOnceRepositoryInterface;
use Kdabrow\SeederOnce\Exceptions\SeederOnceException;
use Kdabrow\SeederOnce\Tests\Integration\Mocks\SeederUsingSeederOnceMock;
use Kdabrow\SeederOnce\Tests\TestCase;

class SeederOnceTest extends TestCase
{
    public function test_is_seeder_once_will_detect_lack_of_table_in_db_and_throw_exception()
    {
        $this->expectException(SeederOnceException::class);

        $mockClass = resolve(SeederUsingSeederOnceMock::class);

        $mockClass->__invoke();
    }

    public function test_if_seed_will_be_executed_when_table_exists()
    {
        $repository = resolve(SeederOnceRepositoryInterface::class);
        $repository->createTable();

        $mockClass = resolve(SeederUsingSeederOnceMock::class);

        $this->assertNull($mockClass->__invoke());
    }
}
