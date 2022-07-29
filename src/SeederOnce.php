<?php

namespace Kdabrow\SeederOnce;

use Illuminate\Console\View\Components\Task;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Support\Arr;
use InvalidArgumentException;
use Kdabrow\SeederOnce\Contracts\SeederOnceRepositoryInterface;

trait SeederOnce
{
    /**
     * Run the given seeder class.
     *
     * @param  array|string  $class
     * @param  bool  $silent
     * @param  array  $parameters
     * @return $this
     */
    public function call($class, $silent = false, array $parameters = [])
    {
        $classes = Arr::wrap($class);

        foreach ($classes as $class) {
            $seeder = $this->resolve($class);

            $name = get_class($seeder);

            if ($silent || ! isset($this->command)) {
                $seeder->__invoke($parameters);
            } else {
                $result = $seeder->__invoke($parameters);

                if ($result === false) {
                    $name = $name . " was already seeded";
                }

                with(new Task($this->command->getOutput()))->render(
                    $name,
                    $result,
                );
            }

            static::$called[] = $class;
        }

        return $this;
    }

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
            return false;
        }

        $callback = function() use ($parameters) {
            return isset($this->container)
                ? $this->container->call([$this, 'run'], $parameters)
                : $this->run(...$parameters);
        };

        $repository->add($name);

        $uses = array_flip(class_uses_recursive(static::class));

        if (isset($uses[WithoutModelEvents::class])) {
            $callback = $this->withoutModelEvents($callback);
        }

        return $callback();
    }

    private function resolveSeederOnceRepository(): SeederOnceRepositoryInterface
    {
        return app(SeederOnceRepositoryInterface::class);
    }
}
