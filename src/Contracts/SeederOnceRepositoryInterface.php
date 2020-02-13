<?php

namespace Kdabrow\SeederOnce\Contracts;

use Illuminate\Support\Collection;

interface SeederOnceRepositoryInterface
{
    /**
     * Adds logs data
     *
     * @param string $fileName
     *
     * @return boolean
     */
    public function add(string $fileName): bool;

    /**
     * @return \Illuminate\Support\Collection
     */
    public function all(): Collection;

    /**
     * Checks if fileName exists in db
     *
     * @param string $fileName
     *
     * @return boolean
     */
    public function isDone(string $fileName): bool;

    /**
     * Creates log file table
     *
     * @return void
     */
    public function createTable();

    /**
     * Checks if log file table exists
     *
     * @return boolean
     */
    public function existsTable(): bool;

    /**
     * Set the information source to gather data.
     *
     * @param  string  $name
     * @return void
     */
    public function setConnection($name);
}
