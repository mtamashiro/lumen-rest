<?php


namespace App\Api\Transaction\FormatResponse;


use Domain\Transaction\Models\Transaction;
use Domain\User\models\NaturalPerson;

class TransactionFormatResponse
{

    public static function format(Transaction $transaction): array
    {
        $payer_document = ($transaction->account_payer->user->person instanceof NaturalPerson) ?
            $transaction->account_payer->user->person->cpf : $transaction->account_payer->user->person->cnpj;

        $payee_document = ($transaction->account_payee->user->person instanceof NaturalPerson) ?
            $transaction->account_payee->user->person->cpf : $transaction->account_payee->user->person->cnpj;

        return ([
            'id' => $transaction->id,
            'value' => $transaction->amount,
            'state' => $transaction->state,
            'updated_at' => $transaction->updated_at,
            'created_at' => $transaction->created_at,
            'payer' => [
                'name' => $transaction->account_payer->user->name,
                'document' => $payer_document,
            ],
            'payee' => [
                'name' => $transaction->account_payee->user->name,
                'document' => $payee_document
            ]
        ]);
    }

}
