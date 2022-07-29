<?php

namespace Kdabrow\SeederOnce\Tests\Commands;

use Kdabrow\SeederOnce\Tests\Database\Seeds\DatabaseSeeder;
use Kdabrow\SeederOnce\Tests\TestCase;

class DbSeedCommandTest extends TestCase
{
    public function test_that_output_print_names_called_by_first_time()
    {
        $this->artisan('db:seed', ['class' => DatabaseSeeder::class])
            ->expectsOutputToContain('SeederCalledOnlyOnce')
            ->expectsOutputToContain('SeederCalledManyTimes');
    }

    public function test_that_output_not_print_names_called_by_second_and_next_time()
    {
        $this->artisan('db:seed', ['class' => DatabaseSeeder::class])
            ->expectsOutputToContain('SeederCalledOnlyOnce')
            ->expectsOutputToContain('SeederCalledManyTimes');

        $this->artisan('db:seed', ['class' => DatabaseSeeder::class])
            ->doesntExpectOutputToContain('SeederCalledOnlyOnce')
            ->expectsOutputToContain('SeederCalledManyTimes');
    }

    public function test_that_output_print_seeded_classes_in_case_of_if_configuration_is_set_so()
    {
        $this->app['config']->set('seederonce.print_already_seeded', true);

        $this->artisan('db:seed', ['class' => DatabaseSeeder::class])
            ->expectsOutputToContain('SeederCalledOnlyOnce')
            ->expectsOutputToContain('SeederCalledManyTimes');

        $this->artisan('db:seed', ['class' => DatabaseSeeder::class])
            ->expectsOutputToContain('SeederCalledOnlyOnce already seeded')
            ->expectsOutputToContain('SeederCalledManyTimes');
    }
}