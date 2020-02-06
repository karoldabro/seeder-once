<?php

namespace Kdabrow\SeederOnce\Tests\Integration\Repositories;

use Kdabrow\SeederOnce\Contracts\SeederRepositoryInterface;
use Kdabrow\SeederOnce\Repositories\SeederRepository;
use Kdabrow\SeederOnce\Tests\TestCase;

class SeederOnceProviderTest extends TestCase
{
    public function test_if_config_is_merged()
    {
        $this->assertTrue(is_array(config('seederonce')));
    }

    public function test_if_repository_is_binded_with_correct_data()
    {
        /**
         * @var $repository SeederRepositoryInterface
         */
        $repository = resolve(SeederRepositoryInterface::class);

        $this->assertInstanceOf(SeederRepository::class, $repository);
    }
}
