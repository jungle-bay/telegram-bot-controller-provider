# Telegram Bot Controller Provider for [Silex](https://silex.symfony.com/)

[![Travis CI](https://img.shields.io/travis/jungle-bay/telegram-bot-controller-provider.svg?style=flat)](https://travis-ci.org/jungle-bay/telegram-bot-controller-provider)
[![Scrutinizer CI](https://img.shields.io/scrutinizer/g/jungle-bay/telegram-bot-controller-provider.svg?style=flat)](https://scrutinizer-ci.com/g/jungle-bay/telegram-bot-controller-provider)
[![Codecov](https://img.shields.io/codecov/c/github/jungle-bay/telegram-bot-controller-provider.svg?style=flat)](https://codecov.io/gh/jungle-bay/telegram-bot-controller-provider)
[![SensioLabsInsight](https://img.shields.io/sensiolabs/i/46abe828-3d9f-4ef4-9663-aaa94d6239f4.svg?style=flat)](https://insight.sensiolabs.com/projects/46abe828-3d9f-4ef4-9663-aaa94d6239f4)

### Install (in a while)

The recommended way to install is through [Composer](https://getcomposer.org):

```bash
composer require jungle-bay/telegram-controller-provider
```

### The simplest example of use

```php
<?php

require_once(__DIR__ . '/vendor/autoload.php');


use Silex\Application;
use Acme\Bots\Telegram\Commands\OrderCmd;
use Acme\Bots\Telegram\Commands\DefaultCmd;
use Silex\Provider\TelegramBotControllerProvider;

$app = new Application();

// url address can be any, in the example is an example from the documentation.
$app->mount('/bot123456:ABC-DEF1234ghIkl-zyx57W2v1u123ew11', new TelegramBotControllerProvider(array(
    'token'    => '123456:ABC-DEF1234ghIkl-zyx57W2v1u123ew11',
    'adapter'  => $cache, // this adapter for Scrapbook library. See the complete: https://github.com/matthiasmullie/scrapbook#adapters
    'commands' => array(
        'default'  => DefaultCmd::class,
        'mappings' => array(
            'order' => OrderCmd::class
        )
    )
)));

$app->run();
```

##### Example implement default command

```php
<?php

namespace Acme\Bots\Telegram\Commands;


use TelegramBotAPI\Types\Update;
use TelegramBotShell\TelegramBotShell;
use TelegramBotShell\Api\TelegramBotCmdInterface;

class DefaultCmd implements TelegramBotCmdInterface {

    /**
     * {@inheritdoc}
     */
    public function exec(TelegramBotShell $tbs, Update $update, $payload = null) {

        $tbs->getTelegramBotAPI()->sendMessage(array(
            'chat_id' => $update->getMessage()->getChat()->getId(),
            'text'    => 'Default Cmd ;)'
        ));
    }
}
```

#### Warning

> Do not forget to install [webhook](https://core.telegram.org/bots/api#setwebhook).
> Example url webhook:
>
> `https://www.example.com/123456:ABC-DEF1234ghIkl-zyx57W2v1u123ew11/`
>
> Remember that webhook will only work on a https connection and method getUpdate not work when include webhook.

### License

This bundle is under the [MIT license](http://opensource.org/licenses/MIT). See the complete license in the file: [here](https://github.com/jungle-bay/telegram-bot-controller-provider/blob/master/license.txt).
