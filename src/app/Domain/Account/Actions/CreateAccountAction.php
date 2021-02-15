<?php


namespace Domain\Account\Actions;


use Domain\Account\DataTransferObjects\AccountData;
use Domain\Account\Models\Account;

class CreateAccountAction
{
    private $accountData;

    public function __construct(AccountData $accountData)
    {
        $this->accountData = $accountData;
    }

    public function execute(): Account
    {
        $account = Account::create([
            'user_id' => $this->accountData->user_id,
            'amount' => $this->accountData->amount
        ]);

        return $account;

    }
}
