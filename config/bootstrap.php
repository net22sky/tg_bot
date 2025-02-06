<?php

use App\Domain\Repository\UserRepositoryInterface;
use App\Domain\Repository\NoteRepositoryInterface;
use App\Infrastructure\Repository\UserRepository;
use App\Infrastructure\Repository\NoteRepository;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\Tools\Setup;

require_once __DIR__ . '/../../vendor/autoload.php';

$isDevMode = true;
$config = Setup::createAnnotationMetadataConfiguration([__DIR__ . "/../src/Domain/Entity"], $isDevMode);

$conn = [
    'driver' => 'pdo_mysql',
    'host' => getenv('DATABASE_HOST'),
    'dbname' => getenv('DATABASE_NAME'),
    'user' => getenv('DATABASE_USER'),
    'password' => getenv('DATABASE_PASSWORD'),
];

$entityManager = EntityManager::create($conn, $config);

// Регистрируем репозитории
$userRepository = new UserRepository($entityManager);
$noteRepository = new NoteRepository($entityManager);

return [
    UserRepositoryInterface::class => $userRepository,
    NoteRepositoryInterface::class => $noteRepository,
    EntityManager::class => $entityManager,
];