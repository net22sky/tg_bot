<?php
// src/Infrastructure/Repository/NoteRepository.php

namespace App\Infrastructure\Repository;

use App\Domain\Entity\Note;
use App\Domain\Repository\NoteRepositoryInterface;
use Doctrine\ORM\EntityManagerInterface;

/**
 * Реализация репозитория для работы с заметками.
 */
class NoteRepository implements NoteRepositoryInterface
{
    /**
     * Конструктор NoteRepository.
     *
     * @param EntityManagerInterface $entityManager Менеджер сущностей Doctrine.
     */
    public function __construct(private EntityManagerInterface $entityManager) {}

    /**
     * Сохраняет заметку.
     *
     * @param Note $note Объект заметки.
     */
    public function save(Note $note): void
    {
        $this->entityManager->persist($note);
        $this->entityManager->flush();
    }

    /**
     * Удаляет заметку.
     *
     * @param Note $note Объект заметки.
     */
    public function remove(Note $note): void
    {
        $this->entityManager->remove($note);
        $this->entityManager->flush();
    }

    /**
     * Находит заметки по идентификатору пользователя.
     *
     * @param int $userId Идентификатор пользователя.
     * @return Note[]
     */
    public function findByUser(int $userId): array
    {
        return $this->entityManager
            ->getRepository(Note::class)
            ->findBy(['user' => $userId]);
    }
}