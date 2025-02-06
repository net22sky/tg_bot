<?php
// src/Application/UseCase/AddReminderUseCase.php

namespace App\Application\UseCase;

use App\Domain\Entity\User;
use App\Domain\Repository\UserRepositoryInterface;
use App\Domain\Repository\ReminderRepositoryInterface;
use DateTimeImmutable;

/**
 * Сценарий использования: Добавление напоминания.
 */
class AddReminderUseCase
{
    public function __construct(
        private UserRepositoryInterface $userRepository,
        private ReminderRepositoryInterface $reminderRepository
    ) {}

    /**
     * Выполняет сценарий добавления напоминания.
     *
     * @param int $telegramId Идентификатор пользователя в Telegram.
     * @param DateTimeImmutable $remindAt Дата и время напоминания.
     * @param string $message Текст напоминания.
     * @throws \Exception Если достигнуто максимальное количество напоминаний.
     */
    public function execute(int $telegramId, DateTimeImmutable $remindAt, string $message): void
    {
        $user = $this->userRepository->findByTelegramId($telegramId);

        if (!$user) {
            $user = new User($telegramId);
            $this->userRepository->save($user);
        }

        $user->addReminder($remindAt, $message);
        $this->userRepository->save($user);
    }
}