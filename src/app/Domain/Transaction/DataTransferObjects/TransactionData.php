<?php


namespace Domain\Transaction\DataTransferObjects;


use Spatie\DataTransferObject\DataTransferObject;

class TransactionData extends DataTransferObject
{
    /** @var int $account_id */
    public $account_payer_id;

    /** @var int $account_payee_id */
    public $account_payee_id;

    /** @var float|int $amount */
    public $amount;

    /** @var string|null $status */
    public $state;

    public static function fromRequest($object): TransactionData
    {
        return new self(
            [
                'account_payer_id' => $object->payer,
                'account_payee_id' => $object->payee,
                'state' => isset($object->state)? $object->state: '',
                'amount' => $object->value,
            ]
        );
    }
}
