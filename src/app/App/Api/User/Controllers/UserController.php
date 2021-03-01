<?php


namespace App\Api\User\Controllers;

use App\Api\User\FormatResponse\UserFormatResponse;
use App\Api\User\Validations\UserRequestValidation;
use App\Core\Http\Controllers\Controller;
use Domain\User\Actions\CreatePersonAction;
use Domain\User\DataTransferObjects\UserData;
use Domain\User\Models\User;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class UserController extends Controller
{
    public function show($id)
    {
        if (!$user = User::find($id)) {
            throw new ModelNotFoundException('User not exists');
        } else {
            return response()->json(UserFormatResponse::format(User::find($id)), 200);
        }
    }

    public function store(Request $request)
    {
        UserRequestValidation::validate($request);

        $userData = UserData::fromRequest($request);
        $createPersonAction = new CreatePersonAction($userData);
        $person = $createPersonAction->execute();
        return response()->json(UserFormatResponse::format($person->person), 201);
    }
}
