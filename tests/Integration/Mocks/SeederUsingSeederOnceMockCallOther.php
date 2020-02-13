<?php

namespace Kdabrow\SeederOnce\Tests\Integration\Mocks;

use Illuminate\Database\Seeder;
use Kdabrow\SeederOnce\SeederOnce;

class SeederUsingSeederOnceMockCallOther extends Seeder
{
    use SeederOnce;

    public function run()
    {
        $this->call(SeederUsingSeederOnceMock::class);
        $this->call(SeederNotUsingSeederOnceMock::class);

        return true;
    }
}
