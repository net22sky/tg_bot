<?php
// src/Domain/Entity/Note.php

namespace App\Domain\Entity;

/**
 * Сущность заметки.
 */
class Note
{
    /** @var int Уникальный идентификатор заметки. */
    private int $id;

    /** @var string Содержание заметки. */
    private string $content;

    /** @var User Пользователь, которому принадлежит заметка. */
    private User $user;

    /**
     * Конструктор Note.
     *
     * @param string $content Содержание заметки.
     * @param User $user Пользователь, которому принадлежит заметка.
     */
    public function __construct(string $content, User $user)
    {
        $this->content = $content;
        $this->user = $user;
    }

    /**
     * Возвращает содержание заметки.
     *
     * @return string
     */
    public function getContent(): string
    {
        return $this->content;
    }

    /**
     * Возвращает пользователя, которому принадлежит заметка.
     *
     * @return User
     */
    public function getUser(): User
    {
        return $this->user;
    }
}