<?php

namespace Acme\Commands;


use TelegramBotAPI\Types\Update;
use TelegramBotShell\TelegramBotShell;
use TelegramBotShell\Api\TelegramBotCmdInterface;

class OrderCmd implements TelegramBotCmdInterface {

    /**
     * @param TelegramBotShell $tbs
     * @param Update $update
     * @param $payload
     */
    public function thanks(TelegramBotShell $tbs, Update $update, $payload) {

        $user = $update->getMessage()->getFrom();

        $message = $tbs->getTelegramBotAPI()->sendMessage(array(
            'chat_id' => $update->getMessage()->getChat()->getId(),
            'text'    => 'Thanks ' . $user->getFirstName() . ' ' . $user->getLastName() . ' !!!'
        ));

        $tbs->finishContext($message->getChat()->getId());
    }

    /**
     * @param TelegramBotShell $tbs
     * @param Update $update
     * @param $payload
     */
    public function selectProduct(TelegramBotShell $tbs, Update $update, $payload) {

        $message = $tbs->getTelegramBotAPI()->sendMessage(array(
            'chat_id' => $update->getMessage()->getChat()->getId(),
            'text'    => 'Your choice ' . $update->getMessage()->getText() . ' !!!'
        ));

        $tbs->nextContext(array(
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
    public function exec(TelegramBotShell $tbs, Update $update, $payload) {

        $message = $tbs->getTelegramBotAPI()->sendMessage(array(
            'chat_id' => $update->getMessage()->getChat()->getId(),
            'text'    => 'Hi, select product ?'
        ));

        $tbs->nextContext(array(
            'chat_id' => $message->getChat()->getId(),
            'context' => array(
                'cmd'    => self::class,
                'method' => 'selectProduct'
            )
        ));
    }
}
