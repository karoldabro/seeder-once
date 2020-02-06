<?php

namespace Kdabrow\SeederOnce\Contracts;

use Illuminate\Support\Collection;

interface SeederRepositoryInterface
{
    public function add(string $seederName, int $hash): bool;

    public function all(): Collection;

    public function rollback(): bool;

    public function wipe(): bool;

    public function createTable();

    public function existsTable(): bool;

    /**
     * Set the information source to gather data.
     *
     * @param  string  $name
     * @return void
     */
    public function setSource($name);
}
