<?php

use Laravel\Lumen\Testing\DatabaseMigrations;
use Laravel\Lumen\Testing\DatabaseTransactions;
use Domain\User\models\NaturalPerson;
use Domain\Account\Models\Account;
use Domain\User\models\JuridicalPerson;

class transactionRoutesTest extends TestCase
{
    public function testTransactionDefaultRoute(){
        $naturalPersonPayer = NaturalPerson::all()->random(1)->first();
        $naturalPersonPayee = NaturalPerson::all()->random(1)->first();
        $juridicalPerson = JuridicalPerson::all()->random(1)->first();

        $transfer = [
            'value' => 100.00,
            'payer' => $naturalPersonPayer->person->id,
            'payee' => $naturalPersonPayee->person->id
        ];

        $account = Account::where('user_id', $naturalPersonPayer->person->id)->first();
        $account->amount = 100;
        $account->save();

        $response = $this->call('POST', '/api/transaction', $transfer);
        $this->assertEquals(201, $response->status());

        $transfer = [
            'value' => '',
            'payer' => $naturalPersonPayer->person->id,
            'payee' => $naturalPersonPayee->person->id
        ];

        $response = $this->call('POST', '/api/transaction', $transfer);

        $this->assertEquals(422, $response->status());

        $transfer = [
            'value' => 100,
            'payer' => 'xxxxxxx',
            'payee' => $naturalPersonPayee->person->id
        ];

        $response = $this->call('POST', '/api/transaction', $transfer);

        $this->assertEquals(404, $response->status());

        $transfer = [
            'value' => 100,
            'payer' => $naturalPersonPayee->person->id,
            'payee' => 'xxxxxxxxx'
        ];

        $response = $this->call('POST', '/api/transaction', $transfer);

        $this->assertEquals(404, $response->status());
        $transfer = [];

        $response = $this->call('POST', '/api/transaction', $transfer);

        $this->assertEquals(404, $response->status());

        $transfer = [
            'value' => 100,
            'payer' => $juridicalPerson->person->id,
            'payee' => $naturalPersonPayee->person->id,
        ];

        $response = $this->call('POST', '/api/transaction', $transfer);
        $this->assertEquals(403, $response->status());

        $transfer = [
            'value' => 100,
            'payer' => $naturalPersonPayer->person->id,
            'payee' => $naturalPersonPayee->person->id,
        ];

        $account = Account::where('user_id', $naturalPersonPayer->person->id)->first();
        $account->amount = 0;
        $account->save();

        $response = $this->call('POST', '/api/transaction', $transfer);
        $this->assertEquals(403, $response->status());

        $transfer = [
            'value' => 100,
            'payer' => $naturalPersonPayer->person->id,
            'payee' => $naturalPersonPayer->person->id,
        ];

        $account = Account::where('user_id', $naturalPersonPayer->person->id)->first();
        $account->amount = 100;
        $account->save();

        $response = $this->call('POST', '/api/transaction', $transfer);
        $this->assertEquals(422, $response->status());
    }
}
