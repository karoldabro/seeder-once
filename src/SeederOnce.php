<?php

namespace Kdabrow\SeederOnce;

use InvalidArgumentException;
use Kdabrow\SeederOnce\Contracts\SeederOnceRepositoryInterface;

trait SeederOnce
{
    /**
     * Run the database seeds.
     *
     * @return mixed
     *
     * @throws \InvalidArgumentException
     */
    public function __invoke(array $parameters = [])
    {
        if (!method_exists($this, 'run')) {
            throw new InvalidArgumentException('Method [run] missing from ' . get_class($this));
        }

        $repository = $this->resolveSeederOnceRepository();

        if (!$repository->existsTable()) {
            $repository->createTable();
        }

        $name = get_class($this);

        if ($repository->isDone($name)) {

            if (isset($this->command)) {
                $this->command->getOutput()->writeln("<error>Seeder:</error> {$name} was already seeded.");
            }

            return null;
        }

        $return = isset($this->container)
            ? $this->container->call([$this, 'run'], $parameters)
            : $this->run(...$parameters);

        $repository->add($name);

        return $return;
    }

    private function resolveSeederOnceRepository(): SeederOnceRepositoryInterface
    {
        return app(SeederOnceRepositoryInterface::class);
    }
}
