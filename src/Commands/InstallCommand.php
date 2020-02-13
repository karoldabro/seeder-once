<?php

namespace Kdabrow\SeederOnce\Commands;

use Illuminate\Console\Command;
use Symfony\Component\Console\Input\InputOption;
use Kdabrow\SeederOnce\Contracts\SeederOnceRepositoryInterface;

class InstallCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'db:install
        {--database= : The database connection to use}
    ';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Creates seeds table';

    /**
     * @var SeederOnceRepositoryInterface
     */
    private $seederRepository;

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct(SeederOnceRepositoryInterface $seederRepository)
    {
        parent::__construct();

        $this->seederRepository = $seederRepository;
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $this->seederRepository->setConnection($this->input->getOption('database'));
        if ($this->seederRepository->existsTable()) {
            return $this->info("Table with seeders already exists");
        }

        $this->seederRepository->createTable();

        $this->info("Seeders table has been created successfully.");
    }
}
