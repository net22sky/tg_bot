<?php
// src/Infrastructure/Repository/ReminderRepository.php

namespace App\Infrastructure\Repository;

use App\Domain\Entity\Reminder;
use App\Domain\Repository\ReminderRepositoryInterface;
use Doctrine\ORM\EntityManagerInterface;
use DateTimeImmutable;

/**
 * Реализация репозитория для работы с напоминаниями.
 */
class ReminderRepository implements ReminderRepositoryInterface
{
    public function __construct(private EntityManagerInterface $entityManager) {}

    /**
     * @inheritDoc
     */
    public function save(Reminder $reminder): void
    {
        $this->entityManager->persist($reminder);
        $this->entityManager->flush();
    }

    /**
     * @inheritDoc
     */
    public function remove(Reminder $reminder): void
    {
        $this->entityManager->remove($reminder);
        $this->entityManager->flush();
    }

    /**
     * @inheritDoc
     */
    public function findDueReminders(): array
    {
        $now = new DateTimeImmutable();
        return $this->entityManager
            ->createQuery('SELECT r FROM App\Domain\Entity\Reminder r WHERE r.remindAt <= :now')
            ->setParameter('now', $now)
            ->getResult();
    }
}