<?php

namespace Kdabrow\SeederOnce\Tests\Integration\Mocks;

use Illuminate\Database\Seeder;

class SeederNotUsingSeederOnceMockCallOther extends Seeder
{
    public function run()
    {
        $this->call(SeederUsingSeederOnceMock::class);
        $this->call(SeederNotUsingSeederOnceMock::class);

        return true;
    }
}
