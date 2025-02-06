<?php
// src/Domain/Entity/User.php

namespace App\Domain\Entity;

/**
 * Сущность пользователя.
 */
class User
{
    // ... (остальные свойства и методы)

    /** @var Reminder[] Список напоминаний пользователя. */
    private array $reminders = [];

    /**
     * Добавляет напоминание пользователю.
     *
     * @param DateTimeImmutable $remindAt Дата и время напоминания.
     * @param string $message Текст напоминания.
     * @throws \Exception Если достигнуто максимальное количество напоминаний.
     */
    public function addReminder(DateTimeImmutable $remindAt, string $message): void
    {
        if (count($this->reminders) >= 10) {
            throw new \Exception("Maximum number of reminders reached (10).");
        }

        $this->reminders[] = new Reminder($remindAt, $message, $this);
    }

    /**
     * Возвращает список напоминаний пользователя.
     *
     * @return Reminder[]
     */
    public function getReminders(): array
    {
        return $this->reminders;
    }
}