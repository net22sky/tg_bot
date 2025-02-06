<?php
// src/Domain/Repository/ReminderRepositoryInterface.php

namespace App\Domain\Repository;

use App\Domain\Entity\Reminder;

/**
 * Интерфейс репозитория для работы с напоминаниями.
 */
interface ReminderRepositoryInterface
{
    /**
     * Сохраняет напоминание.
     *
     * @param Reminder $reminder Объект напоминания.
     */
    public function save(Reminder $reminder): void;

    /**
     * Удаляет напоминание.
     *
     * @param Reminder $reminder Объект напоминания.
     */
    public function remove(Reminder $reminder): void;

    /**
     * Находит напоминания, которые нужно отправить.
     *
     * @return Reminder[]
     */
    public function findDueReminders(): array;
}