<?php


namespace Domain\Transaction\Actions;

use App\Core\Exceptions\CustomExceptions\NotAllowedAction;
use Domain\Account\Models\Account;
use Domain\Transaction\DataTransferObjects\TransactionData;
use Domain\Transaction\Models\Transaction;
use Domain\Transaction\Policy\UserPermissionPolicy;

class TransactionAction
{
    private $transactionData;

    public function __construct(TransactionData $transactionData)
    {
        $this->transactionData = $transactionData;
    }


    public function execute(): Transaction
    {
        $account_payer = Account::where('user_id', $this->transactionData->account_payer_id)->first();
        $userPermissionPolicy = new UserPermissionPolicy();

        if ($userPermissionPolicy->isTransferAllowed($account_payer->user)) {
            $transaction = Transaction::create([
                'account_payer_id' => $this->transactionData->account_payer_id,
                'account_payee_id' => $this->transactionData->account_payee_id,
                'amount' => $this->transactionData->amount,
                'state' => Transaction::getDefaultStateFor('state')
            ]);

            $transaction->transfer();
            return $transaction;
        } else {
            throw new NotAllowedAction('Juridical person is not allowed to perform this action');
        }
    }
}
