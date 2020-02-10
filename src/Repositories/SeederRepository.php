<?php

namespace Kdabrow\SeederOnce\Repositories;

use Carbon\Carbon;
use Illuminate\Support\Collection;
use Illuminate\Database\ConnectionResolverInterface;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Config;
use Kdabrow\SeederOnce\Contracts\FilesLogRepositoryInterface;

class SeederRepository implements FilesLogRepositoryInterface
{

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

    public function setSource($name)
    {
    }

    /**
     * ---------
     * Interface
     * ---------
     */

    /**
     * @inheritDoc
     */
    public function add(string $fileName, int $hash): bool
    {
        $table = $this->table();

        return $table->insert([
            'name' => $fileName,
            'hash' => $hash,
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
            $blueprint->integer('hash');
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
