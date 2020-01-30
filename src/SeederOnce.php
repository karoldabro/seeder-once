<?php

namespace Kdabrow\SeederOnce;

use InvalidArgumentException;
use Kdabrow\SeederOnce\Tests\NotImplementedException;

trait SeederOnce
{
    public function callOnce()
    {
        throw new NotImplementedException();
    }

    /**
     * Run the database seeds.
     *
     * @return mixed
     *
     * @throws \InvalidArgumentException
     */
    public function __invoke()
    {
        if (method_exists($this, 'run')) {
            $this->runOrCall();
        }

        if (method_exists($this, 'runOnce')) {
            $this->runOrCall('runOnce');
        }

        throw new InvalidArgumentException('Method [run] or method [runOnce] are missing from ' . get_class($this));
    }

    private function runOrCall(string $methodName = 'run')
    {
        return isset($this->container)
            ? $this->container->call([$this, $methodName])
            : $this->$methodName();
    }
}
