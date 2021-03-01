<?php


namespace Domain\Account\Actions;

use App\Core\Exceptions\CustomExceptions\NotAllowedAction;
use Domain\Account\Models\Account;
use Domain\Account\DataTransferObjects\AccountData;

class WithdrawAction
{
    private $accountData;

    public function __construct(AccountData $accountData)
    {
        $this->accountData = $accountData;
    }

    public function execute($amount): Account
    {
        $account = Account::find($this->accountData->id);

        if ($account->amount >= $amount) {
            $account->amount -= $amount;
            $account->save();
        } else {
            throw new NotAllowedAction('You do not have enough account balance');
        }

        return $account;
    }
}
