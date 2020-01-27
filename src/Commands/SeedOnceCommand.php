<?php

namespace Kdabrow\SeederOnce\Commands;

use Illuminate\Console\Command;

class SeedOnceCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'db:once';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Seed your data only once';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
    }
}
