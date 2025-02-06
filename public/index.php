<?php
// public/index.php

require_once __DIR__ . '/../vendor/autoload.php';

use App\Application\Service\TelegramBotService;
use App\Application\UseCase\AddNoteUseCase;
use App\Application\UseCase\AddReminderUseCase;
use App\Application\UseCase\DeleteNoteUseCase;
use App\Application\UseCase\ListNotesUseCase;
use App\Infrastructure\Adapter\TelegramBotAdapter;
use App\Infrastructure\Repository\NoteRepository;
use App\Infrastructure\Repository\ReminderRepository;
use App\Infrastructure\Repository\UserRepository;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\Tools\Setup;
use TelegramBot\Api\Client;

// Настройка Doctrine ORM
$isDevMode = true;
$config = Setup::createAnnotationMetadataConfiguration(
    [__DIR__ . "/../src/Domain/Entity"],
    $isDevMode
);

$conn = [
    'driver' => 'pdo_mysql',
    'host' => getenv('DATABASE_HOST') ?: 'localhost',
    'dbname' => getenv('DATABASE_NAME') ?: 'telegram_bot',
    'user' => getenv('DATABASE_USER') ?: 'root',
    'password' => getenv('DATABASE_PASSWORD') ?: '',
];

$entityManager = EntityManager::create($conn, $config);

// Репозитории
$userRepository = new UserRepository($entityManager);
$noteRepository = new NoteRepository($entityManager);
$reminderRepository = new ReminderRepository($entityManager);

// Use Cases
$addNoteUseCase = new AddNoteUseCase($userRepository, $noteRepository);
$addReminderUseCase = new AddReminderUseCase($userRepository, $reminderRepository);
$deleteNoteUseCase = new DeleteNoteUseCase($userRepository, $noteRepository);
$listNotesUseCase = new ListNotesUseCase($userRepository, $noteRepository);

// Адаптер Telegram
$telegramBotAdapter = new TelegramBotAdapter(getenv('TELEGRAM_BOT_TOKEN') ?: 'YOUR_TELEGRAM_BOT_TOKEN');

// Сервис бота
$telegramBotService = new TelegramBotService(
    $addNoteUseCase,
    $addReminderUseCase,
    $deleteNoteUseCase,
    $listNotesUseCase
);

// Клиент Telegram API
$telegram = new Client(getenv('TELEGRAM_BOT_TOKEN') ?: 'YOUR_TELEGRAM_BOT_TOKEN');

// Обработка входящих сообщений
$telegram->on(function ($update) use ($telegramBotService) {
    $message = $update->getMessage();
    $telegramBotService->handle($message);
}, function () {
    return true;
});

// Запуск бота
$telegram->run();