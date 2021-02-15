<?php


namespace Domain\Transaction\States;


use Domain\Account\Actions\DepositAction;
use Domain\Account\Actions\WithdrawAction;
use Domain\Account\DataTransferObjects\AccountData;
use Domain\Account\Models\Account;
use Domain\Transaction\Models\Transaction;
use Illuminate\Support\Facades\DB;

class AuthorizedTransaction extends TransactionStates
{
    public static $name = 'Authorized';

    public function execute(Transaction $transaction): bool
    {
        DB::beginTransaction();

        $payer = Account::find($transaction->account_payer->id);
        $accountPayerData = AccountData::fromRequest($payer);
        $withdrawAction = new WithdrawAction($accountPayerData);
        $withdrawAction->execute($transaction->amount);

        $payee = Account::find($transaction->account_payee->id);
        $accountPayeeData = AccountData::fromRequest($payee);
        $depositAction = new DepositAction($accountPayeeData);
        $depositAction->execute($transaction->amount);

        try{
            DB::commit();
            $transaction->state->transitionTo(CompletedTransaction::class);
            return $transaction->state->execute($transaction);
        }catch (\Exception $e){
            DB::rollBack();
            $transaction->state->transitionTo(FailedTransaction::class);
            return $transaction->state->execute($transaction);
        }

    }
}
