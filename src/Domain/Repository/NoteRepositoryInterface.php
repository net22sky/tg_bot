<?php
// src/Domain/Repository/NoteRepositoryInterface.php

namespace App\Domain\Repository;

use App\Domain\Entity\Note;

/**
 * Интерфейс репозитория для работы с заметками.
 */
interface NoteRepositoryInterface
{
    /**
     * Сохраняет заметку.
     *
     * @param Note $note Объект заметки.
     */
    public function save(Note $note): void;

    /**
     * Удаляет заметку.
     *
     * @param Note $note Объект заметки.
     */
    public function remove(Note $note): void;

    /**
     * Находит заметки по идентификатору пользователя.
     *
     * @param int $userId Идентификатор пользователя.
     * @return Note[]
     */
    public function findByUser(int $userId): array;
}