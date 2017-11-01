# Telegram Bot Controller Provider for [Silex](https://silex.symfony.com/)

[![Travis CI](https://img.shields.io/travis/jungle-bay/telegram-controller-provider.svg?style=flat)](https://travis-ci.org/jungle-bay/telegram-controller-provider)
[![Scrutinizer CI](https://img.shields.io/scrutinizer/g/jungle-bay/telegram-controller-provider.svg?style=flat)](https://scrutinizer-ci.com/g/jungle-bay/telegram-controller-provider)
[![Codecov](https://img.shields.io/codecov/c/github/jungle-bay/telegram-controller-provider.svg?style=flat)](https://codecov.io/gh/jungle-bay/telegram-controller-provider)
[![SensioLabsInsight](https://img.shields.io/sensiolabs/i/16f94065-ba61-4ec9-851c-3fbfdca7e1c9.svg?style=flat)](https://insight.sensiolabs.com/projects/16f94065-ba61-4ec9-851c-3fbfdca7e1c9)

### Install (in a while)

The recommended way to install is through [Composer](https://getcomposer.org):

```bash
composer require jungle-bay/telegram-controller-provider
```

### The simplest example of use

```php
<?php

use Silex\Application;
use Acme\Commands\HelloCmd;
use Acme\Commands\DefaultCmd;
use Silex\Provider\TelegramControllerProvider;

$app = new Application();

// url address can be any, in the example is an example from the documentation.
$app->mount('/123456:ABC-DEF1234ghIkl-zyx57W2v1u123ew11', new TelegramControllerProvider(array(
    // your bot token.
    'token' => '123456:ABC-DEF1234ghIkl-zyx57W2v1u123ew11',
    'cmd'   => array(
        // if the command is not found in the list.
        'default'  => DefaultCmd::class,
        // key is the name of the command,
        // the value is the class in which the behavior of the command should be described.
        'mappings' => array(
            'hello' => HelloCmd::class
        )
    )
)));

$app->run();
```

##### Example implement hello command

```php
<?php

namespace Acme\Commands;


use Silex\Application;
use TelegramBotAPI\Types\Update;
use TelegramBotAPI\TelegramBotAPI;
use Silex\Api\TelegramCommandInterface;

class HelloCmd implements TelegramCommandInterface {

    public function exec(Application $app, Update $update) {

        /** @var TelegramBotAPI $tba */
        $tba = $app['tba'];

        $tba->sendMessage(array(
            'chat_id' => $update->getMessage()->getChat()->getId(),
            'text'    => 'Hello my friend ' . $update->getMessage()->getFrom()->getFirstName() . ' !'
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
> Remember that webhook will only work on a https connection.

### License

This bundle is under the [MIT license](http://opensource.org/licenses/MIT). See the complete license in the file: [here](https://github.com/jungle-bay/telegram-controller-provider/blob/master/license.txt).