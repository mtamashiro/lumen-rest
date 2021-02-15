<?php


namespace Support\Notification;


use GuzzleHttp\Client;

class ExternalNotification
{
    public static function notify($message): bool
    {
        $client = new Client();
        $response = $client->request('GET', 'https://run.mocky.io/v3/b19f7b9f-9cbf-4fc6-ad22-dc30601aec04');

        $response = json_decode($response->getBody());

        if($response->message === 'Enviado'){
            return true;
        }else{
            return false;
        }
    }
}
