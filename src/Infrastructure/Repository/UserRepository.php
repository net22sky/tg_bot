<?php
// src/Infrastructure/Repository/UserRepository.php

namespace App\Infrastructure\Repository;

use App\Domain\Entity\User;
use App\Domain\Repository\UserRepositoryInterface;
use Doctrine\ORM\EntityManagerInterface;

/**
 * Реализация репозитория для работы с пользователями.
 */
class UserRepository implements UserRepositoryInterface
{
    /**
     * Конструктор UserRepository.
     *
     * @param EntityManagerInterface $entityManager Менеджер сущностей Doctrine.
     */
    public function __construct(private EntityManagerInterface $entityManager) {}

    /**
     * @inheritDoc
     */
    public function findByTelegramId(int $telegramId): ?User
    {
        return $this->entityManager->getRepository(User::class)->findOneBy(['telegramId' => $telegramId]);
    }

    /**
     * @inheritDoc
     */
    public function save(User $user): void
    {
        $this->entityManager->persist($user);
        $this->entityManager->flush();
    }
}