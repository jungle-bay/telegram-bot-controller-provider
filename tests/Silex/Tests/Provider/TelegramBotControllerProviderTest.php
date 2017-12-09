<?php
/**
 * Created by PhpStorm.
 * Team: jungle
 * User: Roma Baranenko
 * Contacts: <jungle.romabb8@gmail.com>
 * Date: 06.12.17
 * Time: 12:27
 */

namespace Silex\Tests\Provider;


use Silex\WebTestCase;
use Silex\Application;
use Silex\Provider\TelegramBotControllerProvider;
use MatthiasMullie\Scrapbook\Adapters\MemoryStore;

/**
 * Class TelegramBotControllerProviderTest
 * @package Silex\Tests\Provider
 * @author Roma Baranenko <jungle.romabb8@gmail.com>
 */
class TelegramBotControllerProviderTest extends WebTestCase {

    /**
     * {@inheritdoc}
     */
    public function createApplication() {

        $app = new Application();

        $app['session.test'] = true;
        $app['debug'] = true;

        unset($app['exception_handler']);

        $adapter = new MemoryStore();

        $app->mount('/bot479218867:AAGjGTwl0F-prMPIC6-AkNuLD1Bb2tRsYbc', new TelegramBotControllerProvider(array(
            'token'   => '479218867:AAGjGTwl0F-prMPIC6-AkNuLD1Bb2tRsYbc',
            'adapter' => $adapter
        )));

        return $app;
    }

    /**
     * @expectedException \TelegramBotShell\Exception\TelegramBotShellException
     */
    public function testTelegramBotControllerProvider() {

        $client = $this->createClient();

        $client->request('POST', '/bot479218867:AAGjGTwl0F-prMPIC6-AkNuLD1Bb2tRsYbc/', array(), array(), array(), '{
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
        }');

        $this->assertTrue($client->getResponse()->isOk());
    }
}
