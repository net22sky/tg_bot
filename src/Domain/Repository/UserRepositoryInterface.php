<?php
// src/Domain/Repository/UserRepositoryInterface.php

namespace App\Domain\Repository;

use App\Domain\Entity\User;

/**
 * Интерфейс репозитория для работы с пользователями.
 */
interface UserRepositoryInterface
{
    /**
     * Находит пользователя по идентификатору Telegram.
     *
     * @param int $telegramId Идентификатор пользователя в Telegram.
     * @return User|null
     */
    public function findByTelegramId(int $telegramId): ?User;

    /**
     * Сохраняет пользователя.
     *
     * @param User $user Объект пользователя.
     */
    public function save(User $user): void;
}