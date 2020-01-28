<?php

namespace Kdabrow\SeederOnce\Repositories;

use Kdabrow\SeederOnce\Contracts\SeederRepositoryInterface;

class SeederRepository implements SeederRepositoryInterface
{
    public function add(string $seederName): bool
    {
    }

    public function all(): Collection;

    public function rollback(): bool;

    public function wipe(): bool;
}
