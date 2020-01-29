<?php

namespace Kdabrow\SeederOnce\Repositories;

use Illuminate\Support\Collection;
use Kdabrow\SeederOnce\Tests\NotImplementedException;
use Kdabrow\SeederOnce\Contracts\SeederRepositoryInterface;
use Kdabrow\SeederOnce\Models\Seeder;

class SeederRepository implements SeederRepositoryInterface
{
    public function add(string $seederName): bool
    {
        $seeder = new Seeder();
        $seeder->seeder = $seederName;

        return $seeder->save();
    }

    public function all(): Collection
    {
        $result = Seeder::all();

        return $result->toBase();
    }

    public function rollback(): bool
    {
        throw new NotImplementedException();

        return true;
    }

    public function wipe(): bool
    {
        throw new NotImplementedException();

        return true;
    }
}
