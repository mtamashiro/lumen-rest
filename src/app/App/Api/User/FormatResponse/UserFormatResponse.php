<?php


namespace App\Api\User\FormatResponse;


use Domain\User\models\NaturalPerson;
use Domain\User\Models\User;

class UserFormatResponse
{

    public static function format(User $user): array
    {
        return ([
            'id' => $user->id,
            'name' => $user->name,
            'personType' => $user->person_type,
            'document' => $user->person instanceof NaturalPerson ? $user->person->cpf : $user->person->cnpj,
            'created_at' => $user->created_at,
            'updated_at' => $user->updated_at,
        ]);
    }
}
