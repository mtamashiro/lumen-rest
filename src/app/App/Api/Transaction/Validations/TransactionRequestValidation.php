<?php


namespace App\Api\Transaction\Validations;


use Domain\User\Models\User;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use InvalidArgumentException;

class TransactionRequestValidation
{
    public static function validate(Request $request): bool
    {
        if(!User::find($request->payer)){
            throw new ModelNotFoundException('Payer not exist');
        }

        if(!User::find($request->payee)){
            throw new ModelNotFoundException('Payee not exist');
        }

        if( $request->payee == $request->payer){
            throw new InvalidArgumentException('payer cannot be the payee');
        }

        if(!is_numeric($request->value) ){
            throw new InvalidArgumentException('Incorrect value field format');
        }else{
            if($request->value <= 0){
                throw new InvalidArgumentException('Value must be greater than 0');
            }
        }

        return true;
    }
}
