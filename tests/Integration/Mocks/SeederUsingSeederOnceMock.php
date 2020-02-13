<?php

namespace Kdabrow\SeederOnce\Tests\Integration\Mocks;

use Illuminate\Database\Seeder;
use Kdabrow\SeederOnce\SeederOnce;

class SeederUsingSeederOnceMock extends Seeder
{
    use SeederOnce;

    public function run()
    {
        return true;
    }
}
