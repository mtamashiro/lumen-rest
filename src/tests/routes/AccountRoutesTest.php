<?php

use Domain\User\Actions\CreatePersonAction;
use Domain\User\DataTransferObjects\UserData;
use Domain\User\Models\User;
use Domain\User\models\NaturalPerson;
use Domain\Account\Models\Account;
use Domain\User\models\JuridicalPerson;

class AccountRoutesTest extends TestCase
{
    private const VALID_CNPJ = '99.967.278/0001-08';
    private const VALID_CPF = '34692288841';
    private const VALID_EMAIL = 'marcelo.s.tamashiro@gmail.com';

    public function testGetAccountRouteSucess()
    {
        $account = Account::All()->first();
        $response = $this->call('GET', '/api/accounts/' . $account->id);
        $this->assertEquals(200, $response->status());
    }

    public function testGetAccountRouteNotFound()
    {
        $response = $this->call('GET', '/api/accounts/2381380jdada0dsa9');
        $this->assertEquals(404, $response->status());
    }

    public function testPostAccountRouteAlreadyExist()
    {
        $account = Account::all()->first();

        $request = [
            'user_id' => $account->user_id,
            'amount' => 0
        ];

        $response = $this->call('POST', '/api/accounts/', $request);
        $this->assertEquals(409, $response->status());
    }


    public function testPostAccountRouteUserNotFound()
    {
        $request = [
            'user_id' => 'dsadsadsadsa',
            'amount' => 0
        ];

        $response = $this->call('POST', '/api/accounts/', $request);
        $this->assertEquals(404, $response->status());
    }

    public function testPostAccountRouteInvalidAmount()
    {
        $this->deleteUser();
        $juridicalPerson = $this->createUser();

        $request = [
            'user_id' => $juridicalPerson->person->id,
            'amount' => 'dsdsadasdsa'
        ];

        $response = $this->call('POST', '/api/accounts/', $request);
        $this->assertEquals(422, $response->status());
    }

    public function testPostAccountRouteNegativeAmount()
    {
        $this->deleteUser();
        $juridicalPerson = $this->createUser();

        $request = [
            'user_id' => $juridicalPerson->person->id,
            'amount' => -100
        ];

        $response = $this->call('POST', '/api/accounts/', $request);
        $this->assertEquals(422, $response->status());
    }

    public function testPostAccountRouteSucess()
    {
        $this->deleteUser();
        $juridicalPerson = $this->createUser();

        $request = [
            'user_id' => $juridicalPerson->person->id,
            'amount' => 0
        ];

        $response = $this->call('POST', '/api/accounts/', $request);
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

    private function createUser()
    {
        $request = [
            "name" => "Marcelo",
            "email" => self::VALID_EMAIL,
            "document" => self::VALID_CNPJ,
            "password" => "dsadsadsadsadsa"
        ];

        $userData = UserData::fromRequest((object)$request);
        $createPersonAction = new CreatePersonAction($userData);
        return $createPersonAction->execute();
    }
}
