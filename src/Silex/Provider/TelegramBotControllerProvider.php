<?php
/**
 * Created by PhpStorm.
 * Team: jungle
 * User: Roma Baranenko
 * Contacts: <jungle.romabb8@gmail.com>
 * Date: 06.12.17
 * Time: 12:27
 */

namespace Silex\Provider;


use Silex\Application;
use Silex\ControllerCollection;
use Silex\Api\ControllerProviderInterface;
use TelegramBotPlatform\TelegramBotPlatform;
use Symfony\Component\HttpFoundation\Request;

/**
 * Class TelegramBotControllerProvider
 * @package Silex\Provider
 * @author Roma Baranenko <jungle.romabb8@gmail.com>
 */
class TelegramBotControllerProvider implements ControllerProviderInterface {

    /**
     * @var array $config
     */
    private $config;


    /**
     * {@inheritdoc}
     */
    public function connect(Application $app) {

        /** @var ControllerCollection $controllers */
        $controllers = $app['controllers_factory'];

        $controllers->match('/', function (Application $app, Request $request) {

            $this->config['payload'] = $app;

            $tbp = new TelegramBotPlatform($this->config, $request->getContent());

            $app['telegram_bot_platform'] = $tbp;

            $tbp->run();

            return $app->json(array());
        });

        return $controllers;
    }


    /**
     * TelegramBotControllerProvider constructor.
     * @param array $config
     */
    public function __construct(array $config) {
        $this->config = $config;
    }
}
