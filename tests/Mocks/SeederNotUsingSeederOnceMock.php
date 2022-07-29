<?php

namespace Kdabrow\SeederOnce\Tests\Mocks;

use Illuminate\Database\Seeder;

class SeederNotUsingSeederOnceMock extends Seeder
{
    public function run()
    {
        return true;
    }
}
