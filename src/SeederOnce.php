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
    public function __invoke()
    {
        if (!method_exists($this, 'run')) {
            throw new InvalidArgumentException('Method [run] missing from ' . get_class($this));
        }

        $name = get_class($this);

        /**
         * @var SeederOnceRepositoryInterface $repository
         */
        $repository = resolve(SeederOnceRepositoryInterface::class);

        if ($repository->isDone($name)) {
        }

        $repository->add($name, '');

        return isset($this->container)
            ? $this->container->call([$this, 'run'])
            : $this->run();
    }
}
