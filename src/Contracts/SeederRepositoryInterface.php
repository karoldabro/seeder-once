<?php

namespace Kdabrow\SeederOnce\Contracts;

use Illuminate\Support\Collection;

interface SeederRepositoryInterface
{
    public function add(string $seederName): bool;

    public function all(): Collection;

    public function rollback(): bool;

    public function wipe(): bool;
}
