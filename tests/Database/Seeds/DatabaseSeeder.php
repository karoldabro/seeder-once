<?php

namespace Kdabrow\SeederOnce\Tests\Database\Seeds;

use Kdabrow\SeederOnce\SeederOnce;

class DatabaseSeeder extends SeederOnce
{
    public bool $seedOnce = false;

    public function run()
    {
        $this->call(SeederCalledOnlyOnce::class);
        $this->call(SeederCalledManyTimes::class);
    }
}