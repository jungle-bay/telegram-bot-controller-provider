<?php
/**
 * Created by PhpStorm.
 * User: toor
 * Date: 18.03.18
 * Time: 9:35
 */

namespace Silex\Application;


use TelegramBotPlatform\TelegramBotPlatform;

/**
 * TelegramBotPlatformTrait trait.
 *
 * @package Silex\Application
 */
trait TelegramBotPlatformTrait {

    /**
     * Get Telegram Bot Platform object.
     *
     * @return TelegramBotPlatform
     */
    public function getTelegramBotPlatform() {
        return $this['telegram_bot_platform'];
    }
}
