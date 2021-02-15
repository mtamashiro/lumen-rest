<?php


namespace Domain\User\Actions;


use Domain\Transaction\States\CompletedTransaction;
use Domain\Transaction\States\FailedTransaction;
use Domain\User\DataTransferObjects\UserData;
use Domain\User\models\JuridicalPerson;
use Domain\User\models\NaturalPerson;
use Domain\User\Models\User;
use http\Exception\InvalidArgumentException;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use PhpParser\Node\Expr\Cast\Object_;
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

        if(ValidateDocuments::validateCNPJ($this->userData->document)){
            $personType = JuridicalPerson::create([
                'cnpj' => $this->userData->document
            ]);
        }else if(ValidateDocuments::validateCPF($this->userData->document)){
            $personType = NaturalPerson::create([
                'cpf' => $this->userData->document
            ]);
        }else{
            throw new InvalidArgumentException('Invalid Document');
        }

        $personType->person()->create([
            'name' => $this->userData->name,
            'email' => $this->userData->email,
            'password' => Hash::make($this->userData->password)
        ]);

        try{
            DB::commit();
            return $personType;
        }catch (\Exception $e){
            throw $e;
        }
    }
}
