<?php

namespace Kdabrow\SeederOnce\Tests\Integration\Mocks;

use Illuminate\Database\Seeder;

class SeederNotUsingSeederOnceMock extends Seeder
{
    public function run()
    {
        return true;
    }
}
