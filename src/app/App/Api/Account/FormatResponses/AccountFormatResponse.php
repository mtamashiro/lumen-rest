<?php


namespace App\Api\Account\FormatResponses;


use Domain\Account\Models\Account;

class AccountFormatResponse
{
    public static function format(Account $account): array
    {
        return ([
            'id' => $account->id,
            'amount' => $account->amount,
            'created_at' => $account->created_at,
            'updated_at' => $account->updated_at,
            'Owner' => [
                'id' => $account->id,
                'name' => $account->user->name
            ]
        ]);
    }
}
