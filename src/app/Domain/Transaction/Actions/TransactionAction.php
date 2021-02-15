<?php


namespace Domain\Transaction\Actions;


use App\Core\Exceptions\CustomExceptions\NotAllowedAction;
use Domain\Account\Models\Account;
use Domain\Transaction\DataTransferObjects\TransactionData;
use Domain\Transaction\Models\Transaction;
use Domain\User\models\JuridicalPerson;

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

        if($account_payer->user->person instanceof JuridicalPerson){
            throw new NotAllowedAction('Juridical person is not allowed to perform this action');
        }

        $transaction = Transaction::create([
            'account_payer_id' => $this->transactionData->account_payer_id,
            'account_payee_id' => $this->transactionData->account_payee_id,
            'amount' => $this->transactionData->amount,
            'state' => Transaction::getDefaultStateFor('state')
        ]);

        $transaction->transfer();

        return $transaction;
    }
}
