<?php

namespace Silex\Provider;


use Silex\Application;
use Silex\ControllerCollection;
use TelegramBotShell\TelegramBotShell;
use Silex\Api\ControllerProviderInterface;
use Symfony\Component\HttpFoundation\Request;
use TelegramBotAPI\Exception\TelegramBotAPIException;

/**
 * @package Silex\Provider
 * @author Roma Baranenko <jungle.romabb8@gmail.com>
 */
class TelegramBotControllerProvider implements ControllerProviderInterface {

    /**
     * @var array $config
     */
    private $config;


    /**
     * @param Application $app
     * @return ControllerCollection
     */
    public function connect(Application $app) {

        /** @var ControllerCollection $controllers */
        $controllers = $app['controllers_factory'];

        $controllers->match('/', function (Application $app, Request $request) {

            $this->config['payload'] = $app;

            $tbs = new TelegramBotShell($this->config, $request->getContent());

            $app['tbs'] = $tbs;

            $tbs->run();

            return $app->json(array());
        });

        return $controllers;
    }

    /**
     * @param array $config
     *
     * @throws TelegramBotAPIException
     */
    public function __construct(array $config) {
        $this->config = $config;
    }
}
