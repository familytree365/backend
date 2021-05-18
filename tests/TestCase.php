<?php
namespace Tests;

use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;
use Illuminate\Support\Facades\Event;
use Spatie\Multitenancy\Concerns\UsesMultitenancyConfig;
use Spatie\Multitenancy\Events\MadeTenantCurrentEvent;

abstract class TestCase extends BaseTestCase
{
use CreatesApplication, DatabaseTransactions, UsesMultitenancyConfig;

protected function connectionsToTransact()
{
return [
$this->landlordDatabaseConnectionName(),
$this->tenantDatabaseConnectionName(),
];
}

protected function setUp(): void
{
parent::setUp();

Event::listen(MadeTenantCurrentEvent::class, function () {
$this->beginDatabaseTransaction();
});
}
}
