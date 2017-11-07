<?php

namespace Acme\Commands;


use TelegramBotAPI\Types\Update;
use TelegramBotShell\TelegramBotShell;
use TelegramBotShell\Api\TelegramBotCmdInterface;

class OrderCmd implements TelegramBotCmdInterface {

    /**
     * @param TelegramBotShell $tbs
     * @param Update $update
     */
    public function thanks(TelegramBotShell $tbs, Update $update) {

        $user = $update->getMessage()->getFrom();

        $message = $tbs->getTelegramBotAPI()->sendMessage(array(
            'chat_id' => $update->getMessage()->getChat()->getId(),
            'text'    => 'Thanks ' . $user->getFirstName() . ' ' . $user->getLastName() . ' !!! x'
        ));

        $tbs->deleteContext($message->getChat()->getId());
    }

    /**
     * @param TelegramBotShell $tbs
     * @param Update $update
     */
    public function selectProduct(TelegramBotShell $tbs, Update $update) {

        $message = $tbs->getTelegramBotAPI()->sendMessage(array(
            'chat_id' => $update->getMessage()->getChat()->getId(),
            'text'    => 'Your choice ' . $update->getMessage()->getText() . ' !!! x'
        ));

        $tbs->setContext(array(
            'chat_id' => $message->getChat()->getId(),
            'context' => array(
                'cmd'    => self::class,
                'method' => 'thanks'
            )
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function exec(TelegramBotShell $tbs, Update $update, $payload = null) {

        $message = $tbs->getTelegramBotAPI()->sendMessage(array(
            'chat_id' => $update->getMessage()->getChat()->getId(),
            'text'    => 'Hi, select product ? x'
        ));

        $tbs->setContext(array(
            'chat_id' => $message->getChat()->getId(),
            'context' => array(
                'cmd'    => self::class,
                'method' => 'selectProduct'
            )
        ));
    }
}
