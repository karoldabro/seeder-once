<?php

namespace Kdabrow\SeederOnce\Tests\Database\Seeds;

use Kdabrow\SeederOnce\SeederOnce;

class SeederCalledManyTimes extends SeederOnce
{
    public bool $seedOnce = false;

    public function run()
    {

    }
}