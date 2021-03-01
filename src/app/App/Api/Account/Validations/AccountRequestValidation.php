<?php


namespace App\Api\Account\Validations;

use App\Core\Exceptions\CustomExceptions\AlreadyExist;
use Domain\Account\Models\Account;
use Domain\User\Models\User;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use InvalidArgumentException;

class AccountRequestValidation
{
    public static function validate(Request $request): bool
    {
        if (!User::find($request->user_id)) {
            throw new ModelNotFoundException('User not exist');
        }

        if ($user = Account::where('user_id', $request->user_id)->first()) {
            throw new AlreadyExist('Athis user already has an account');
        }

        if (!is_numeric($request->amount)) {
            throw new InvalidArgumentException('Incorrect value field format');
        } else {
            if ($request->amount < 0) {
                throw new InvalidArgumentException('Value must be greater than 0');
            }
        }

        return true;
    }
}
