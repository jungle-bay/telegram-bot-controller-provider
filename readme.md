<p align="center">
    <a href="https://github.com/jungle-bay/telegram-bot-controller-provider">
        <img height="128" src="logo.png" alt="Telegram Bot Controller Provider Logo">
    </a>
</p>

# Telegram Bot Controller Provider for [Silex](https://silex.symfony.com/)

[![Travis CI](https://img.shields.io/travis/jungle-bay/telegram-bot-controller-provider.svg?style=flat)](https://travis-ci.org/jungle-bay/telegram-bot-controller-provider)
[![Scrutinizer CI](https://img.shields.io/scrutinizer/g/jungle-bay/telegram-bot-controller-provider.svg?style=flat)](https://scrutinizer-ci.com/g/jungle-bay/telegram-bot-controller-provider)
[![Codecov](https://img.shields.io/codecov/c/github/jungle-bay/telegram-bot-controller-provider.svg?style=flat)](https://codecov.io/gh/jungle-bay/telegram-bot-controller-provider)

### Install

The recommended way to install is through [Composer](https://getcomposer.org/doc/00-intro.md#introduction):

```bash
composer require jungle-bay/telegram-bot-controller-provider
```

### The simplest example of use

```php
<?php

require_once __DIR__ . DIRECTORY_SEPARATOR . implode(DIRECTORY_SEPARATOR, array('vendor', 'autoload.php'));

$app = new \Silex\Application();

$app->mount('/bot123456:ABC-DEF1234ghIkl-zyx57W2v1u123ew11', new \Silex\Provider\TelegramBotControllerProvider(array(
    'token'    => '123456:ABC-DEF1234ghIkl-zyx57W2v1u123ew11',                 // Your token bot.
    'storage'  => $adapter,                                                    // This adapter for Scrapbook library to store user sessions. See the complete adapters: https://github.com/matthiasmullie/scrapbook#adapters
    'mappings' => array(
        'default'       => \Acme\Bot\Commands\DefaultCmd::class,               // This command will work by default if no command is found or user session. (optional)
        'inline_query'  => \Acme\Bot\Commands\FeedbackInlineQueryCmd::class,   // This command will work with inline queries. (optional)
        'commands'      => array(                                              // This is the list of registered commands for the bot. (optional)
            'help' => \Acme\Bot\Commands\HelpCmd::class,
            'user' => \Acme\Bot\Commands\UserCmd::class
        )
    )
)));

$app->run();
```

##### Example implement command

```php
<?php

namespace Acme\Bot\Commands;


use TelegramBotAPI\Types\Update;
use TelegramBotPlatform\TelegramBotPlatform;
use TelegramBotPlatform\Api\TelegramBotCommandInterface;

class DefaultCmd implements TelegramBotCommandInterface {

    /**
     * {@inheritdoc}
     */
    public function execute(TelegramBotPlatform $tbp, Update $update, $payload = null) {
        
        if (null === $update->getMessage()) return false;

        $tbp->getTelegramBotAPI()->sendMessage(array(
            'chat_id' => $update->getMessage()->getChat()->getId(),
            'text'    => 'Default Cmd ;)'
        ));
        
        return true;
    }
}
```

#### Warning

> Do not forget to install [webhook](https://core.telegram.org/bots/api#setwebhook)! Example url webhook:
>
> ```https://www.example.com/bot123456:ABC-DEF1234ghIkl-zyx57W2v1u123ew11/```
>
> Remember that webhook will only work on a ```HTTPS``` connection and method ```getUpdates``` not work when include [webhook](https://core.telegram.org/bots/api#setwebhook).

### Note

For the convenience of development, you can use [Telegram Bot CLI](https://github.com/jungle-bay/telegram-bot-cli).

### License

This bundle is under the [MIT license](http://opensource.org/licenses/MIT). See the complete license in the file: [here](https://github.com/jungle-bay/telegram-bot-controller-provider/blob/master/license.txt).
