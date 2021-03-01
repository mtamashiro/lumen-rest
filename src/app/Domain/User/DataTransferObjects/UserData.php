<?php

namespace Domain\User\DataTransferObjects;

use Spatie\DataTransferObject\DataTransferObject;

class UserData extends DataTransferObject
{
    /** @var string $name */
    public $name;

    /** @var string $document */
    public $document;

    /** @var string $email */
    public $email;

    /** @var string $password */
    public $password;

    public static function fromRequest($object): UserData
    {
        return new self(
            [
                'name' => $object->name,
                'document' => $object->document,
                'email' => $object->email,
                'password' => $object->password
            ]
        );
    }
}
