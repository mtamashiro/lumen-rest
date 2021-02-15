<?php

use Domain\Account\Actions\CreateAccountAction;
use Domain\Account\DataTransferObjects\AccountData;
use Domain\User\Actions\CreatePersonAction;
use Domain\User\DataTransferObjects\UserData;
use \Domain\User\models\JuridicalPerson;
use \Domain\User\models\NaturalPerson;
use \Domain\User\models\user;
use Domain\Account\Models\Account;

class CreateAccountActionTest extends TestCase
{
    private const VALID_CNPJ = '99.967.278/0001-08';
    private const VALID_CPF = '34692288841';
    private const VALID_EMAIL = 'marcelo.s.tamashiro@gmail.com';

    public function testCreateAccount(){
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

        $request = [
            'user_id' => $juridicalPerson->person->id,
            'amount' => 0
        ];

        $accountData = AccountData::fromRequest((object)$request);
        $createAccountAction = new CreateAccountAction($accountData);
        $account = $createAccountAction->execute();

        $this->assertTrue($account instanceof Account);
        $this->assertEquals($account->amount, 0);
        $this->assertEquals($account->user_id,  $juridicalPerson->person->id);
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
