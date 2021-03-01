<?php


namespace Domain\Transaction\States;

use Domain\Transaction\Models\Transaction;
use Domain\Transaction\Services\ExternalAuthorizationService;

class PendingTransaction extends TransactionStates
{
    public static $name = 'Pending';

    public function execute(Transaction $transaction): bool
    {
        if (ExternalAuthorizationService::check()) {
            $transaction->state->transitionTo(AuthorizedTransaction::class);
            return $transaction->state->execute($transaction);
        } else {
            $transaction->state->transitionTo(DeniedTransaction::class);
            return $transaction->state->execute($transaction);
        }
    }
}
