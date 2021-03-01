<?php


namespace App\Api\Account\Controllers;

use App\Api\Account\FormatResponse\AccountFormatResponse;
use App\Api\Account\Validations\AccountRequestValidation;
use App\Core\Http\Controllers\Controller;
use Domain\Account\Actions\CreateAccountAction;
use Domain\Account\DataTransferObjects\AccountData;
use Domain\Account\Models\Account;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class AccountController extends Controller
{
    public function show($id)
    {
        if (!$user = Account::find($id)) {
            throw new ModelNotFoundException('Account not exists');
        } else {
            return response()->json(AccountFormatResponse::format(Account::find($id)), 200);
        }
    }

    public function store(Request $request)
    {
        AccountRequestValidation::validate($request);

        $accountData = AccountData::fromRequest($request);
        $createAccountAction = new CreateAccountAction($accountData);
        $account = $createAccountAction->execute();
        return response()->json(AccountFormatResponse::format($account), 201);
    }
}
