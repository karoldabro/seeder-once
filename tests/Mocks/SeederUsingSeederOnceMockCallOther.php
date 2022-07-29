<?php

namespace Kdabrow\SeederOnce\Tests\Mocks;

use Kdabrow\SeederOnce\SeederOnce;

class SeederUsingSeederOnceMockCallOther extends SeederOnce
{
    public function run()
    {
        $this->call(SeederUsingSeederOnceMock::class);
        $this->call(SeederNotUsingSeederOnceMock::class);

        return true;
    }
}
