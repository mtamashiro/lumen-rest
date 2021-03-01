<?php

use Domain\User\Models\User;
use Domain\User\models\NaturalPerson;
use Domain\Account\Models\Account;
use Domain\User\models\JuridicalPerson;

class userRoutesTest extends TestCase
{
    private const VALID_CNPJ = '99.967.278/0001-08';
    private const VALID_CPF = '34692288841';
    private const VALID_EMAIL = 'marcelo.s.tamashiro@gmail.com';

    public function testGetUserRouteSucess()
    {
        $user = User::All()->first();

        $response = $this->call('GET', '/api/user/' . $user->id);
        $this->assertEquals(200, $response->status());
    }

    public function testGetUserRouteAlreadyExist()
    {
        $response = $this->call('GET', '/api/user/2381380jdada0dsa9');
        $this->assertEquals(404, $response->status());
    }

    public function testPostUserRouteInvalidFields()
    {
        $this->deleteUser();
        $request = [
            "name" => "Marcelo",
            "email" => 'dsadsa',
            "document" => 'ewqwewq',
            "password" => "dsadsadsadsadsa"
        ];
        $response = $this->call('POST', '/api/user/', $request);
        $this->assertEquals(422, $response->status());
    }

    public function testPostUserRouteInvalidEmail()
    {
        $this->deleteUser();
        $request = [
            "name" => "Marcelo",
            "email" => 'dsadsa',
            "document" => self::VALID_CPF,
            "password" => "dsadsadsadsadsa"
        ];

        $response = $this->call('POST', '/api/user/', $request);
        $this->assertEquals(422, $response->status());
    }

    public function testPostUserRouteInvalidDocument()
    {
        $this->deleteUser();
        $request = [
            "name" => "Marcelo",
            "email" => self::VALID_EMAIL,
            "document" => 'dsadsadsa',
            "password" => "dsadsadsadsadsa"
        ];

        $response = $this->call('POST', '/api/user/', $request);
        $this->assertEquals(422, $response->status());
    }

    public function testPostUserRouteSuccess()
    {
        $this->deleteUser();
        $request = [
            "name" => "Marcelo",
            "email" => self::VALID_EMAIL,
            "document" => self::VALID_CPF,
            "password" => "dsadsadsadsadsa"
        ];
        $response = $this->call('POST', '/api/user/', $request);
        $this->assertEquals(201, $response->status());
    }

    public function testPostUserRouteAlreadyExist()
    {
        $request = [
            "name" => "Marcelo",
            "email" => self::VALID_EMAIL,
            "document" => self::VALID_CPF,
            "password" => "dsadsadsadsadsa"
        ];

        $response = $this->call('POST', '/api/user/', $request);
        $this->assertEquals(409, $response->status());

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
