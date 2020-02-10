<?php

namespace Kdabrow\SeederOnce\Tests\Integration\Commands;

use Illuminate\Support\Facades\Schema;
use Kdabrow\SeederOnce\Tests\TestCase;

class InstallCommandTest extends TestCase
{
    public function test_if_command_install_creates_table_in_database()
    {
        $this->artisan('db:install', [
            '--database' => 'testing'
        ]);

        $this->assertTrue(Schema::hasTable(\config('seederonce.table_name')));
    }
}
