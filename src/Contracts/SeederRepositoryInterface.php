<?php

namespace Kdabrow\SeederOnce\Contracts;

use Illuminate\Support\Collection;

interface FilesLogRepositoryInterface
{
    /**
     * Adds logs data
     *
     * @param string $fileName
     * @param integer $hash
     *
     * @return boolean
     */
    public function add(string $fileName, int $hash): bool;

    /**
     * @return \Illuminate\Support\Collection
     */
    public function all(): Collection;

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
    public function setSource($name);
}
