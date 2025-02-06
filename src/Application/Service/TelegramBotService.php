<?php
// src/Application/Service/TelegramBotService.php

namespace App\Application\Service;

use App\Application\UseCase\AddNoteUseCase;
use App\Application\UseCase\AddReminderUseCase;
use App\Application\UseCase\DeleteNoteUseCase;
use App\Application\UseCase\ListNotesUseCase;
use TelegramBot\Api\Types\Message;

/**
 * Сервис для обработки команд Telegram-бота.
 */
class TelegramBotService
{
    public function __construct(
        private AddNoteUseCase $addNoteUseCase,
        private AddReminderUseCase $addReminderUseCase,
        private DeleteNoteUseCase $deleteNoteUseCase,
        private ListNotesUseCase $listNotesUseCase
    ) {}

    /**
     * Обрабатывает входящее сообщение от пользователя.
     *
     * @param Message $message Входящее сообщение.
     */
    public function handle(Message $message): void
    {
        $chatId = $message->getChat()->getId();
        $text = $message->getText();

        try {
            if (strpos($text, '/addnote') === 0) {
                $this->handleAddNote($chatId, $text);
            } elseif (strpos($text, '/addreminder') === 0) {
                $this->handleAddReminder($chatId, $text);
            } elseif ($text === '/deletenote') {
                $this->handleDeleteNote($chatId);
            } elseif ($text === '/listnotes') {
                $this->handleListNotes($chatId);
            } else {
                $this->sendMessage($chatId, "Unknown command. Available commands: /addnote, /addreminder, /deletenote, /listnotes");
            }
        } catch (\Exception $e) {
            $this->sendMessage($chatId, "Error: " . $e->getMessage());
        }
    }

    /**
     * Обрабатывает команду добавления заметки.
     *
     * @param int $chatId Идентификатор чата.
     * @param string $text Текст команды.
     */
    private function handleAddNote(int $chatId, string $text): void
    {
        $content = trim(str_replace('/addnote', '', $text));

        if (empty($content)) {
            $this->sendMessage($chatId, "Note content cannot be empty.");
            return;
        }

        $this->addNoteUseCase->execute($chatId, $content);
        $this->sendMessage($chatId, "Note added successfully.");
    }

    /**
     * Обрабатывает команду добавления напоминания.
     *
     * @param int $chatId Идентификатор чата.
     * @param string $text Текст команды.
     */
    private function handleAddReminder(int $chatId, string $text): void
    {
        $parts = explode(' ', $text, 3); // Формат: /addreminder <дата и время> <текст>
        if (count($parts) < 3) {
            $this->sendMessage($chatId, "Invalid format. Use: /addreminder <YYYY-MM-DD HH:MM> <message>");
            return;
        }

        $dateTimeString = $parts[1];
        $message = $parts[2];

        try {
            $remindAt = new \DateTimeImmutable($dateTimeString);
        } catch (\Exception $e) {
            $this->sendMessage($chatId, "Invalid date format. Use: YYYY-MM-DD HH:MM");
            return;
        }

        $this->addReminderUseCase->execute($chatId, $remindAt, $message);
        $this->sendMessage($chatId, "Reminder added successfully.");
    }

    /**
     * Обрабатывает команду удаления последней заметки.
     *
     * @param int $chatId Идентификатор чата.
     */
    private function handleDeleteNote(int $chatId): void
    {
        $this->deleteNoteUseCase->execute($chatId);
        $this->sendMessage($chatId, "Last note deleted successfully.");
    }

    /**
     * Обрабатывает команду получения списка заметок.
     *
     * @param int $chatId Идентификатор чата.
     */
    private function handleListNotes(int $chatId): void
    {
        $notes = $this->listNotesUseCase->execute($chatId);

        if (empty($notes)) {
            $this->sendMessage($chatId, "You have no notes.");
            return;
        }

        $message = "Your notes:\n";
        foreach ($notes as $note) {
            $message .= "- " . $note->getContent() . "\n";
        }

        $this->sendMessage($chatId, $message);
    }

    /**
     * Отправляет сообщение пользователю.
     *
     * @param int $chatId Идентификатор чата.
     * @param string $message Текст сообщения.
     */
    private function sendMessage(int $chatId, string $message): void
    {
        // Здесь можно использовать TelegramBotAdapter для отправки сообщений.
        // Например:
        // $telegramBotAdapter->sendMessage($chatId, $message);
        echo "Sending message to chat $chatId: $message\n"; // Для тестирования
    }
}