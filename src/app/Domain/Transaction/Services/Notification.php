<?php


namespace Domain\Transaction\Services;


use Support\Notification\ExternalNotification;

class Notification extends ExternalNotification
{
    public static function notify($message): bool
    {
        return parent::notify($message);
    }
}
