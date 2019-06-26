<?php

namespace dcb9\redis\tests;

use Yii;
use dcb9\redis\Connection;
use dcb9\redis\Session;

class SessionTest extends TestCase
{
    public function testSession()
    {
        $this->mockApplication([
            'components' => [
                'redis' => array_merge(self::getParam(), [
                    'class' => Connection::class,
                ]),
                'session' => Session::class,
            ]
        ]);

        $sessionId = 'sessionId';
        $session = Yii::$app->session;
        $sessionData = json_encode([
            'sessionId' => $sessionId,
            'username' => 'bob',
        ]);

        $session->writeSession($sessionId, $sessionData);

        $this->assertEquals($sessionData, $session->readSession($sessionId));
        $this->assertTrue($session->destroySession($sessionId));
        $this->assertEquals('', $session->readSession($sessionId));
    }
}
