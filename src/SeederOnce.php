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
            throw new SeederOnceException("Table to store logged seeders do not exists in your database. Please run command: php artisan db:install in order to create it.");
        }

        $name = get_class($this);

        if ($repository->isDone($name)) {

            if (isset($this->command)) {
                $this->command->getOutput()->writeln("<error>Seeder:</error> {$name} was already seeded.");
            }

            return null;
        }

        $return = isset($this->container)
            ? $this->container->call([$this, 'run'])
            : $this->run();

        $repository->add($name);

        return $return;
    }

    private function resolveSeederOnceRepository(): SeederOnceRepositoryInterface
    {
        return resolve(SeederOnceRepositoryInterface::class);
    }
}
