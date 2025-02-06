<?php
// src/Infrastructure/Adapter/TelegramBotAdapter.php

namespace App\Infrastructure\Adapter;

use TelegramBot\Api\BotApi;

/**
 * Адаптер для взаимодействия с Telegram API.
 */
class TelegramBotAdapter
{
    /** @var BotApi Клиент Telegram Bot API. */
    private BotApi $bot;

    /**
     * Конструктор TelegramBotAdapter.
     *
     * @param string $token Токен Telegram бота.
     */
    public function __construct(string $token)
    {
        $this->bot = new BotApi($token);
    }

    /**
     * Отправляет сообщение пользователю.
     *
     * @param int $chatId Идентификатор чата.
     * @param string $message Текст сообщения.
     */
    public function sendMessage(int $chatId, string $message): void
    {
        $this->bot->sendMessage($chatId, $message);
    }
}