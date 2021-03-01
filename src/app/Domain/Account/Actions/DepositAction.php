<?php


namespace Domain\Account\Actions;

use Domain\Account\Models\Account;
use Domain\Account\DataTransferObjects\AccountData;

class DepositAction
{
    private $accountData;

    public function __construct(AccountData $accountData)
    {
        $this->accountData = $accountData;
    }

    public function execute($amount): Account
    {
        $account = Account::find($this->accountData->id);

        $account->amount += $amount;
        $account->save();
        return $account;
    }
}
