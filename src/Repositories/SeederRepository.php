<?php

namespace Kdabrow\SeederOnce\Repositories;

use Carbon\Carbon;
use Illuminate\Support\Collection;
use Illuminate\Database\ConnectionResolverInterface;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Config;
use Kdabrow\SeederOnce\Contracts\SeederOnceRepositoryInterface;

/**
 * I didn't wrote all this class.
 * Some parts of this class are taken from Illuminate\Database\Migrations\DatabaseMigrationRepository
 */
class SeederRepository implements SeederOnceRepositoryInterface
{
    /**
     * ---------
     * From Illuminate\Database\Migrations\DatabaseMigrationRepository
     * ---------
     */

    /**
     * The database connection resolver instance.
     *
     * @var ConnectionResolverInterface
     */
    protected $resolver;

    /**
     * The name of the migration table.
     *
     * @var string
     */
    protected $table;

    /**
     * The name of the database connection to use.
     *
     * @var string
     */
    protected $connection;

    /**
     * Create a new database migration repository instance.
     *
     * @param  ConnectionResolverInterface  $resolver
     * @param  string  $table
     * @return void
     */
    public function __construct(ConnectionResolverInterface $resolver, $table)
    {
        $this->table = $table;
        $this->resolver = $resolver;
    }

    /**
     * Get a query builder for the migration table.
     *
     * @return \Illuminate\Database\Query\Builder
     */
    protected function table()
    {
        return $this->getConnection()->table($this->table)->useWritePdo();
    }

    /**
     * Get the connection resolver instance.
     *
     * @return \Illuminate\Database\ConnectionResolverInterface
     */
    public function getConnectionResolver()
    {
        return $this->resolver;
    }

    /**
     * Resolve the database connection instance.
     *
     * @return \Illuminate\Database\Connection
     */
    public function getConnection()
    {
        return $this->resolver->connection($this->connection);
    }

    /**
     * Database connection name
     *
     * @param string $name
     *
     * @return void
     */
    public function setConnection($name)
    {
        $this->connection = $name;
    }

    /**
     * ---------
     * My interface
     * ---------
     */

    /**
     * @inheritDoc
     */
    public function isDone(string $fileName): bool
    {
        return !$this->table()
            ->select('*')
            ->where('name', '=', $fileName)
            ->get()
            ->isEmpty();
    }

    /**
     * @inheritDoc
     */
    public function add(string $fileName): bool
    {
        $table = $this->table();

        return $table->insert([
            'name' => $fileName,
            'created_at' => Carbon::now()
        ]);
    }

    /**
     * @inheritDoc
     */
    public function all(): Collection
    {
        $table = $this->table();

        return collect($table->get());
    }

    /**
     * @inheritDoc
     */
    public function createTable()
    {
        $schema = $this->getConnection()->getSchemaBuilder();

        $schema->create(Config::get('seederonce.table_name'), function (Blueprint $blueprint) {
            $blueprint->increments('id');
            $blueprint->string('name');
            $blueprint->dateTime('created_at');
        });
    }

    /**
     * @inheritDoc
     */
    public function existsTable(): bool
    {
        $schema = $this->getConnection()->getSchemaBuilder();

        return $schema->hasTable(Config::get('seederonce.table_name'));
    }
}
