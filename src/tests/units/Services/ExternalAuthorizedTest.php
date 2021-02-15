<?php


use Laravel\Lumen\Testing\DatabaseMigrations;
use Laravel\Lumen\Testing\DatabaseTransactions;
use Domain\Transaction\Services\ExternalAuthorizationService;

class ExternalAuthorizedTest extends TestCase
{

    public function testExternalAuthorized()
    {
        $this->assertTrue(ExternalAuthorizationService::check());
    }
}
