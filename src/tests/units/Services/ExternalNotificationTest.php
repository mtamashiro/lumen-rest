<?php

use \Support\Notification\ExternalNotification;

class ExternalNotificationTest extends TestCase
{
    public function testExternalNotification(){
        $this->assertTrue(ExternalNotification::notify('Teste'));
    }
}
