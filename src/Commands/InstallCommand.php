<?php

namespace Kdabrow\SeederOnce\Commands;

use Illuminate\Console\Command;
use Symfony\Component\Console\Input\InputOption;
use Kdabrow\SeederOnce\Contracts\SeederRepositoryInterface;

class InstallCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'db:install';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Creates seeds table';

    /**
     * @var SeederRepositoryInterface
     */
    private $seederRepository;

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct(SeederRepositoryInterface $seederRepository)
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
        $this->seederRepository->setSource($this->input->getOption('database'));
        $this->seederRepository->createTable();
    }

    /**
     * Get the console command options.
     *
     * @return array
     */
    protected function getOptions()
    {
        return [
            ['database', null, InputOption::VALUE_OPTIONAL, 'The database connection to use'],
        ];
    }
}
