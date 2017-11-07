<?php

namespace Acme\Commands;


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
