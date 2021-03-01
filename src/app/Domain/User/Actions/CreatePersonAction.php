<?php


namespace Domain\User\Actions;

use Domain\User\DataTransferObjects\UserData;
use Domain\User\models\JuridicalPerson;
use Domain\User\models\NaturalPerson;
use http\Exception\InvalidArgumentException;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Support\Util\ValidateDocuments;

class CreatePersonAction
{
    private $userData;

    public function __construct(UserData $userData)
    {
        $this->userData = $userData;
    }

    public function execute()
    {
        DB::beginTransaction();

        if (ValidateDocuments::validateCNPJ($this->userData->document)) {
            $personType = JuridicalPerson::create([
                'cnpj' => $this->userData->document
            ]);
        } elseif (ValidateDocuments::validateCPF($this->userData->document)) {
            $personType = NaturalPerson::create([
                'cpf' => $this->userData->document
            ]);
        } else {
            throw new InvalidArgumentException('Invalid Document');
        }

        $personType->person()->create([
            'name' => $this->userData->name,
            'email' => $this->userData->email,
            'password' => Hash::make($this->userData->password)
        ]);

        try {
            DB::commit();
            return $personType;
        } catch (\Exception $e) {
            throw $e;
        }
    }
}
