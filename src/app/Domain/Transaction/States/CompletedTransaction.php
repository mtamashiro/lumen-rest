<?php


namespace Domain\Transaction\States;

use Domain\Transaction\Models\Transaction;
use Domain\Transaction\Services\Notification;

class CompletedTransaction extends TransactionStates
{
    public static $name = 'Completed';

    public function execute(Transaction $transaction): bool
    {
        Notification::notify('Você recebeu R$'.$transaction->amount);
        return true;
    }
}
