<?php


namespace Domain\Transaction\States;

use Domain\Transaction\Models\Transaction;

class DeniedTransaction extends TransactionStates
{
    public static $name = 'Denied';

    public function execute(Transaction $transaction): bool
    {
        return false;
    }
}
