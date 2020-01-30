<?php

namespace Kdabrow\SeederOnce\Tests\Unit\Mocks;

use Illuminate\Database\Seeder;
use Kdabrow\SeederOnce\SeederOnce;

class WithBothMethodsSeederMock extends Seeder
{
    use SeederOnce;

    public function run()
    {
        return true;
    }

    public function runOnce()
    {
        return false;
    }
}
