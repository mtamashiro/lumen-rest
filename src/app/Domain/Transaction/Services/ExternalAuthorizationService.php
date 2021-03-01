<?php


namespace Domain\Transaction\Services;

use GuzzleHttp\Client;

class ExternalAuthorizationService
{

    public static function check(): bool
    {
        $client = new Client();
        $res = $client->request('GET', 'https://run.mocky.io/v3/8fafdd68-a090-496f-8c9a-3442cf30dae6');

        $message = json_decode($res->getBody());

        if ($message->message === 'Autorizado') {
            return true;
        } else {
            return false;
        }
    }
}
