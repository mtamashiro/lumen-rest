<?php


namespace App\Core\Exceptions\CustomExceptions;


class AlreadyExist extends \Exception
{
    public function __construct(string $message)
    {
        parent::__construct($message);
    }
}
