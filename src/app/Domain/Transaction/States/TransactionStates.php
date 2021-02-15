<?php


namespace Domain\Transaction\States;

use Domain\Transaction\Models\Transaction;
use Spatie\ModelStates\State;
use Spatie\ModelStates\StateConfig;

abstract class TransactionStates extends State
{
    abstract public function execute(Transaction $transaction): bool;

    public static function config(): StateConfig
    {
        return parent::config()
            ->default(PendingTransaction::class)
            ->allowTransition(PendingTransaction::class, DeniedTransaction::class)
            ->allowTransition(PendingTransaction::class, AuthorizedTransaction::class)
            ->allowTransition(AuthorizedTransaction::class, FailedTransaction::class)
            ->allowTransition(AuthorizedTransaction::class, CompletedTransaction::class)
            ;
    }
}
