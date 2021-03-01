<?php


namespace Domain\Account\DataTransferObjects;

use Spatie\DataTransferObject\DataTransferObject;

class AccountData extends DataTransferObject
{
    /** @var int|null $id */
    public $id;

    /** @var int $user_id */
    public $user_id;

    /** @var float|int $amount */
    public $amount;

    public static function fromRequest($object): AccountData
    {
        return new self(
            [
                'id' => isset($object->id) ? $object->id : null,
                'user_id' => $object->user_id,
                'amount' => $object->amount,
            ]
        );
    }
}
