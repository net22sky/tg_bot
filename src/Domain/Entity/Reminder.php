<?php
// src/Domain/Entity/Reminder.php

namespace App\Domain\Entity;

use DateTimeImmutable;

/**
 * Сущность напоминания.
 */
class Reminder
{
    /** @var int Уникальный идентификатор напоминания. */
    private int $id;

    /** @var DateTimeImmutable Дата и время напоминания. */
    private DateTimeImmutable $remindAt;

    /** @var string Текст напоминания. */
    private string $message;

    /** @var User Пользователь, которому принадлежит напоминание. */
    private User $user;

    /**
     * Конструктор Reminder.
     *
     * @param DateTimeImmutable $remindAt Дата и время напоминания.
     * @param string $message Текст напоминания.
     * @param User $user Пользователь, которому принадлежит напоминание.
     */
    public function __construct(DateTimeImmutable $remindAt, string $message, User $user)
    {
        $this->remindAt = $remindAt;
        $this->message = $message;
        $this->user = $user;
    }

    /**
     * Возвращает уникальный идентификатор напоминания.
     *
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * Возвращает дату и время напоминания.
     *
     * @return DateTimeImmutable
     */
    public function getRemindAt(): DateTimeImmutable
    {
        return $this->remindAt;
    }

    /**
     * Возвращает текст напоминания.
     *
     * @return string
     */
    public function getMessage(): string
    {
        return $this->message;
    }

    /**
     * Возвращает пользователя, которому принадлежит напоминание.
     *
     * @return User
     */
    public function getUser(): User
    {
        return $this->user;
    }
}