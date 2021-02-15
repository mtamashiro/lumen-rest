<?php

use App\Core\Exceptions\CustomExceptions\NotAllowedAction;
use Laravel\Lumen\Testing\DatabaseMigrations;
use Laravel\Lumen\Testing\DatabaseTransactions;
use Domain\Account\DataTransferObjects\AccountData;
use \Domain\Account\Models\Account;
use \Domain\Account\Actions\WithdrawAction;

class withdrawActionTest extends TestCase
{
    public function testWithdrawAction()
    {
        $account = Account::All()->random(1)->first();

        $account->amount = 10000;
        $account->save();

        $accountData = AccountData::fromRequest($account);
        $withdrawAction = new WithdrawAction($accountData);
        $account = $withdrawAction->execute(100);

        $expectResult = 10000 - 100;

        $this->assertEquals(
            $account->amount, $expectResult
        );
    }

    public function testWithdrawActionCashlessAccountException()
    {
        $account = Account::All()->random(1)->first();

        $account->amount = 0;
        $account->save();

        $accountData = AccountData::fromRequest($account);
        $withdrawAction = new WithdrawAction($accountData);

        $this->expectException(NotAllowedAction::class);
        $withdrawAction->execute(100);
    }

    public function testWithdrawActionSameValueAndAmountOnAccountException()
    {
        $account = Account::All()->random(1)->first();

        $value = 100;

        $account->amount = $value;
        $account->save();

        $accountData = AccountData::fromRequest($account);
        $withdrawAction = new WithdrawAction($accountData);

        $account = $withdrawAction->execute($value);

        $this->assertEquals(
            $account->amount, 0
        );
    }
}
