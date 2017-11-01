<?php

namespace Silex\Tests\Provider;


use Silex\WebTestCase;
use Silex\Application;
use Acme\Bot\Commands\OrderCmd;
use Acme\Bot\Commands\DefaultCmd;
use TelegramBotAPI\TelegramBotAPI;
use TelegramBotShell\TelegramBotShell;
use Silex\Provider\TelegramBotControllerProvider;
use Symfony\Component\HttpKernel\HttpKernelInterface;

/**
 * @package Silex\Tests\Provider
 * @author Roma Baranenko <jungle.romabb8@gmail.com>
 */
class TelegramBotControllerProviderTest extends WebTestCase {

    /**
     * @return array
     */
    public function dataProvider() {

        $requestDefaultCmd = '{"ok": true,"result": [{
            "update_id": 747719235,
            "message": {
                "message_id": 1591,
                "from": {
                    "id": 59673324,
                    "is_bot": false,
                    "first_name": "Roma",
                    "last_name": "Baranenko",
                    "username": "roma_bb8",
                    "language_code": "ru"
                },
                "chat": {
                    "id": 59673324,
                    "first_name": "Roma",
                    "last_name": "Baranenko",
                    "username": "roma_bb8",
                    "type": "private"
                },
                "date": 1508587194,
                "text": "/cmd",
                "entities": [
                    {
                        "offset": 0,
                        "length": 4,
                        "type": "bot_command"
                    }
                ]
            }
        }]}';

        $requestOrderExec = '{"ok": true,"result": [{
            "update_id": 747719235,
            "message": {
                "message_id": 1591,
                "from": {
                    "id": 59673324,
                    "is_bot": false,
                    "first_name": "Roma",
                    "last_name": "Baranenko",
                    "username": "roma_bb8",
                    "language_code": "ru"
                },
                "chat": {
                    "id": 59673324,
                    "first_name": "Roma",
                    "last_name": "Baranenko",
                    "username": "roma_bb8",
                    "type": "private"
                },
                "date": 1508587194,
                "text": "/order",
                "entities": [
                    {
                        "offset": 0,
                        "length": 6,
                        "type": "bot_command"
                    }
                ]
            }
        }]}';

        $requestOrderSelectProduct = '{"ok": true,"result": [{
            "update_id": 747719235,
            "message": {
                "message_id": 1591,
                "from": {
                    "id": 59673324,
                    "is_bot": false,
                    "first_name": "Roma",
                    "last_name": "Baranenko",
                    "username": "roma_bb8",
                    "language_code": "ru"
                },
                "chat": {
                    "id": 59673324,
                    "first_name": "Roma",
                    "last_name": "Baranenko",
                    "username": "roma_bb8",
                    "type": "private"
                },
                "date": 1508587194,
                "text": "nike cortez"
            }
        }]}';

        $requestOrderThanks = '{"ok": true,"result": [{
            "update_id": 747719235,
            "message": {
                "message_id": 1591,
                "from": {
                    "id": 59673324,
                    "is_bot": false,
                    "first_name": "Roma",
                    "last_name": "Baranenko",
                    "username": "roma_bb8",
                    "language_code": "ru"
                },
                "chat": {
                    "id": 59673324,
                    "first_name": "Roma",
                    "last_name": "Baranenko",
                    "username": "roma_bb8",
                    "type": "private"
                },
                "date": 1508587194,
                "text": "ok!"
            }
        }]}';

        return array(
            array($requestDefaultCmd),
            array($requestOrderExec),
            array($requestOrderSelectProduct),
            array($requestOrderThanks)
        );
    }


    /**
     * @return HttpKernelInterface
     */
    public function createApplication() {

        $app = new Application();

        $app['session.test'] = true;
        $app['debug'] = true;

        unset($app['exception_handler']);

        $app->mount('/bot479218867:AAGjGTwl0F-prMPIC6-AkNuLD1Bb2tRsYbc', new TelegramBotControllerProvider(array(
            'token'    => '479218867:AAGjGTwl0F-prMPIC6-AkNuLD1Bb2tRsYbc',
            'memcache' => array(
                'host' => '127.0.0.1',
                'port' => 11211
            ),
            'commands' => array(
                'default'  => DefaultCmd::class,
                'mappings' => array(
                    'order' => OrderCmd::class
                )
            )
        )));

        return $app;
    }

    /**
     * @param string $request
     *
     * @dataProvider dataProvider
     */
    public function testCmd($request) {

        $client = $this->createClient();

        $client->request('POST', '/bot479218867:AAGjGTwl0F-prMPIC6-AkNuLD1Bb2tRsYbc/', array(), array(), array(), $request);

        $this->assertTrue($client->getResponse()->isOk());
        $this->assertInstanceOf(TelegramBotShell::class, $this->app['tbs']);
        $this->assertInstanceOf(TelegramBotAPI::class, $this->app['tbs']->getTelegramBotAPI());
    }
}
