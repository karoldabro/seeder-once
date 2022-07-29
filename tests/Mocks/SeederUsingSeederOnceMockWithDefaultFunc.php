<?php

namespace Kdabrow\SeederOnce\Tests\Mocks;

use Illuminate\Database\Seeder;
use Kdabrow\SeederOnce\SeederOnce;

class SeederUsingSeederOnceMockWithDefaultFunc extends SeederOnce
{
    public bool $seedOnce = false;

    public function run()
    {
        return true;
    }
}
