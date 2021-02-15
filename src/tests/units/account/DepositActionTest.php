<?php

use Domain\Account\DataTransferObjects\AccountData;
use Domain\Account\Models\Account;
use Laravel\Lumen\Testing\DatabaseMigrations;
use Laravel\Lumen\Testing\DatabaseTransactions;
use Domain\Account\Actions\DepositAction;

class depositActionTest extends TestCase
{
    public function testDepositSuccess()
    {
        $account = Account::All()->random(1)->first();

        $account->amount = 10000;
        $account->save();

        $accountData = AccountData::fromRequest($account);
        $depositAction = new DepositAction($accountData);
        $account = $depositAction->execute(100);

        $expectResult = 10000 + 100;

        $this->assertEquals(
            $account->amount, $expectResult
        );
    }
}
