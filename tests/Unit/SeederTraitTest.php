<?php

namespace Kdabrow\SeederOnce\Tests\Unit;

use Mockery;
use InvalidArgumentException;
use Kdabrow\SeederOnce\Tests\TestCase;
use Kdabrow\SeederOnce\Tests\Unit\Mocks\WithRunMethodSeederMock;
use Kdabrow\SeederOnce\Tests\Unit\Mocks\WithoutMethodsSeederMock;
use Kdabrow\SeederOnce\Tests\Unit\Mocks\WithRunOnceMethodSeederMock;

class SeederTraitTest extends TestCase
{
    public function test_if_methods_run_or_run_once_do_not_exists_then_throw_exception()
    {
        $this->expectException(InvalidArgumentException::class);

        $seeder = new WithoutMethodsSeederMock();

        $seeder();
    }

    public function test_if_method_run_once_can_be_called()
    {
        $seeder = new WithRunOnceMethodSeederMock();

        $this->assertTrue($seeder());
    }

    public function test_if_method_run_can_be_called()
    {
        $seeder = new WithRunMethodSeederMock();

        $this->assertTrue($seeder());
    }
}
