<?php

namespace Kdabrow\SeederOnce\Tests\Mocks;

use Illuminate\Database\Seeder;
use Kdabrow\SeederOnce\SeederOnce;

class SeederUsingSeederOnceMock extends SeederOnce
{
    public function run()
    {
        return true;
    }
}
