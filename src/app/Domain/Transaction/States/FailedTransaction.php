<?php


namespace Domain\Transaction\States;

use Domain\Transaction\Models\Transaction;

class FailedTransaction extends TransactionStates
{
    public static $name = 'Failed';

    public function execute(Transaction $transaction): bool
    {
        return false;
    }
}
