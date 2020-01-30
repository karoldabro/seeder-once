<?php

namespace Kdabrow\SeederOnce\Tests\Unit\Mocks;

use Illuminate\Database\Seeder;
use Kdabrow\SeederOnce\SeederOnce;

class WithRunMethodSeederMock extends Seeder
{
    use SeederOnce;

    public function run()
    {
        return true;
    }
}
