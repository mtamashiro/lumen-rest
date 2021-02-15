<?php

use Domain\User\Actions\CreatePersonAction;
use Domain\User\DataTransferObjects\UserData;
use Domain\User\Models\User;
use Laravel\Lumen\Testing\DatabaseMigrations;
use Laravel\Lumen\Testing\DatabaseTransactions;
use Domain\User\models\NaturalPerson;
use Domain\Account\Models\Account;
use Domain\User\models\JuridicalPerson;

class AccountRoutesTest extends TestCase
{
    private const VALID_CNPJ = '99.967.278/0001-08';
    private const VALID_CPF = '34692288841';
    private const VALID_EMAIL = 'marcelo.s.tamashiro@gmail.com';

    public function testGetAccountRoute()
    {
        $account = Account::All()->first();

        $response = $this->call('GET', '/api/account/'.$account->id);
        $this->assertEquals(200, $response->status());

        $response = $this->call('GET', '/api/account/2381380jdada0dsa9');
        $this->assertEquals(404, $response->status());
    }

    public function testPostAccountRoute(){
        $this->deleteUser();
        $request = [
            "name" => "Marcelo",
            "email" => self::VALID_EMAIL,
            "document" => self::VALID_CNPJ,
            "password" => "dsadsadsadsadsa"
        ];

        $userData = UserData::fromRequest((object)$request);
        $createPersonAction = new CreatePersonAction($userData);
        $juridicalPerson = $createPersonAction->execute();

        $account = Account::all()->first();

        $request = [
            'user_id' => $account->user_id,
            'amount' => 0
        ];

        $response = $this->call('POST', '/api/account/', $request);
        $this->assertEquals(409, $response->status());

        $request = [
            'user_id' => 'dsadsadsadsa',
            'amount' => 0
        ];

        $response = $this->call('POST', '/api/account/', $request);
        $this->assertEquals(404, $response->status());

        $request = [
            'user_id' => $juridicalPerson->person->id,
            'amount' => 'dsdsadasdsa'
        ];

        $response = $this->call('POST', '/api/account/', $request);
        $this->assertEquals(422, $response->status());

        $request = [
            'user_id' => $juridicalPerson->person->id,
            'amount' => -100
        ];

        $response = $this->call('POST', '/api/account/', $request);
        $this->assertEquals(422, $response->status());

        $request = [
            'user_id' => $juridicalPerson->person->id,
            'amount' => 0
        ];

        $response = $this->call('POST', '/api/account/', $request);
        $this->assertEquals(201, $response->status());

        $this->deleteUser();
    }


    private function deleteUser()
    {
        if ($user = User::where('email', self::VALID_EMAIL)->first()) {
            Account::where('user_id', $user->id)->delete();
        }

        User::where('email', self::VALID_EMAIL)->delete();
        NaturalPerson::where('cpf', self::VALID_CPF)->delete();
        JuridicalPerson::where('cnpj', self::VALID_CNPJ)->delete();
    }
}
