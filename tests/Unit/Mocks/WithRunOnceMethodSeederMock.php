<?php

namespace Kdabrow\SeederOnce\Tests\Unit\Mocks;

use Illuminate\Database\Seeder;
use Kdabrow\SeederOnce\SeederOnce;

class WithRunOnceMethodSeederMock extends Seeder
{
    use SeederOnce;

    public function runOnce()
    {
        return true;
    }
}
