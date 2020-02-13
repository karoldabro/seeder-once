<?php

namespace Kdabrow\SeederOnce\Tests\Integration\Commands;

use Illuminate\Support\Facades\Schema;
use Kdabrow\SeederOnce\Tests\TestCase;

class InstallCommandTest extends TestCase
{
    public function test_if_command_install_creates_table_in_database()
    {
        $this->artisan('db:install')
            ->expectsOutput("Seeders table has been created successfully.");

        $this->assertTrue(Schema::hasTable(\config('seederonce.table_name')));
    }

    public function test_if_creating_second_time_will_not_be_executed()
    {
        $this->artisan('db:install')
            ->expectsOutput("Seeders table has been created successfully.");

        $this->artisan('db:install')
            ->expectsOutput("Table with seeders already exists");
    }
}
