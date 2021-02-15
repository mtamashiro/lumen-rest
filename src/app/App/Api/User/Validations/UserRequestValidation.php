<?php


namespace App\Api\User\Validations;


use App\Core\Exceptions\CustomExceptions\AlreadyExist;
use Domain\User\models\JuridicalPerson;
use Domain\User\models\NaturalPerson;
use Domain\User\Models\User;
use Illuminate\Http\Request;
use InvalidArgumentException;
use Support\Util\ValidateDocuments;

class UserRequestValidation
{
    public static function validate(Request $request): bool
    {
        if ($user = User::where('email', $request->email)->first()) {
            throw new AlreadyExist('email is already registered');
        }

        if ($user = NaturalPerson::where('cpf', $request->document)->first() ||
            $user = JuridicalPerson::where('cnpj', $request->document)->first()
        ) {
            throw new AlreadyExist('document is already registered');
        }

        if(!ValidateDocuments::validateCPF($request->document) && !ValidateDocuments::validateCNPJ($request->document)){
            throw new InvalidArgumentException('Invalid Document');
        }

        if(!filter_var($request->email, FILTER_VALIDATE_EMAIL)){
            throw new InvalidArgumentException('Invalid email');
        }

        return true;
    }
}
