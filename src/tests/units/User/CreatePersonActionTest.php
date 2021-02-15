<?php

use App\Core\Exceptions\CustomExceptions\AlreadyExist;
use Domain\User\DataTransferObjects\UserData;
use Domain\User\Actions\CreatePersonAction;
use \Domain\User\models\JuridicalPerson;
use \Domain\User\models\NaturalPerson;
use \Domain\User\models\user;
use Domain\Account\Models\Account;

class CreatePersonActionTest extends TestCase
{
    private const VALID_CNPJ = '99.967.278/0001-08';
    private const VALID_CPF = '34692288841';
    private const VALID_EMAIL = 'marcelo.s.tamashiro@gmail.com';

    public function testCreateJuridicalPerson()
    {
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

        $this->assertTrue($juridicalPerson instanceof JuridicalPerson);
        $this->assertTrue($juridicalPerson->person instanceof User);

        $this->deleteUser();
    }

    public function testCreateNaturalPerson()
    {
        $this->deleteUser();

        $request = [
            "name" => "Marcelo",
            "email" => self::VALID_EMAIL,
            "document" => self::VALID_CPF,
            "password" => "dsadsadsadsadsa"
        ];

        $userData = UserData::fromRequest((object)$request);
        $createPersonAction = new CreatePersonAction($userData);
        $naturalPerson = $createPersonAction->execute();

        $this->assertTrue($naturalPerson instanceof NaturalPerson);
        $this->assertTrue($naturalPerson->person instanceof User);

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
