<?php

namespace Tests;

use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Event;
use Spatie\Multitenancy\Concerns\UsesMultitenancyConfig;
use Spatie\Multitenancy\Events\MadeTenantCurrentEvent;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication, DatabaseTransactions, UsesMultitenancyConfig, WithFaker;

    /**
     * @return array
     */
    protected function connectionsToTransact()
    {
        return [
            $this->landlordDatabaseConnectionName(),
            $this->tenantDatabaseConnectionName(),
        ];
    }

    /**
     * @return void
     */
    protected function setUp(): void
    {
        parent::setUp();

        Event::listen(
            MadeTenantCurrentEvent::class,
            function () {
                $this->beginDatabaseTransaction();
            }
        );
    }
}
