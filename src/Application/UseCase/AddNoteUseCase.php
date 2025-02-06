<?php
// src/Application/UseCase/AddNoteUseCase.php

namespace App\Application\UseCase;

use App\Domain\Repository\UserRepositoryInterface;
use App\Domain\Repository\NoteRepositoryInterface;

/**
 * Сценарий использования: Добавление заметки.
 */
class AddNoteUseCase
{
    /**
     * Конструктор AddNoteUseCase.
     *
     * @param UserRepositoryInterface $userRepository Репозиторий пользователей.
     * @param NoteRepositoryInterface $noteRepository Репозиторий заметок.
     */
    public function __construct(
        private UserRepositoryInterface $userRepository,
        private NoteRepositoryInterface $noteRepository
    ) {}

    /**
     * Выполняет сценарий добавления заметки.
     *
     * @param int $telegramId Идентификатор пользователя в Telegram.
     * @param string $content Содержание заметки.
     * @throws \Exception Если достигнуто максимальное количество заметок.
     */
    public function execute(int $telegramId, string $content): void
    {
        $user = $this->userRepository->findByTelegramId($telegramId);

        if (!$user) {
            $user = new User($telegramId);
            $this->userRepository->save($user);
        }

        if (count($user->getNotes()) >= 100) {
            throw new \Exception("Maximum number of notes reached (100).");
        }

        $user->addNote($content);
        $this->userRepository->save($user);
    }
}