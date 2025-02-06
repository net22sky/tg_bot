<?php
// scripts/send_reminders.php

require_once __DIR__ . '/../vendor/autoload.php';

use App\Infrastructure\Adapter\TelegramBotAdapter;
use App\Infrastructure\Repository\ReminderRepository;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\Tools\Setup;

// Настройка Doctrine
$entityManager = require __DIR__ . '/../config/bootstrap.php';

// Репозиторий напоминаний
$reminderRepository = new ReminderRepository($entityManager);

// Адаптер Telegram
$telegramBotAdapter = new TelegramBotAdapter('YOUR_TELEGRAM_BOT_TOKEN');

// Получаем напоминания, которые нужно отправить
$dueReminders = $reminderRepository->findDueReminders();

foreach ($dueReminders as $reminder) {
    $chatId = $reminder->getUser()->getTelegramId();
    $message = $reminder->getMessage();

    // Отправляем напоминание
    $telegramBotAdapter->sendMessage($chatId, $message);

    // Удаляем отправленное напоминание
    $reminderRepository->remove($reminder);
}