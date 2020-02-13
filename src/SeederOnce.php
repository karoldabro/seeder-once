<?php

namespace Kdabrow\SeederOnce;

use InvalidArgumentException;
use Kdabrow\SeederOnce\Contracts\SeederOnceRepositoryInterface;
use Kdabrow\SeederOnce\Exceptions\SeederOnceException;

trait SeederOnce
{
    /**
     * Run the database seeds.
     *
     * @return mixed
     *
     * @throws \InvalidArgumentException
     */
    public function __invoke()
    {
        if (!method_exists($this, 'run')) {
            throw new InvalidArgumentException('Method [run] missing from ' . get_class($this));
        }

        $repository = $this->resolveSeederOnceRepository();

        if (!$repository->existsTable()) {
            throw new SeederOnceException("Table to log seeders do not exists. Please run: php artisan db:install");
        }

        return isset($this->container)
            ? $this->container->call([$this, 'run'])
            : $this->run();
    }

    private function resolveSeederOnceRepository(): SeederOnceRepositoryInterface
    {
        return resolve(SeederOnceRepositoryInterface::class);
    }
}
