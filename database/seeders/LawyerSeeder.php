<?php

require_once __DIR__ . '/../../vendor/autoload.php';

use LawFirmManagement\Core\Env;
use LawFirmManagement\Core\Database;
use LawFirmManagement\Repositories\UserRepository;

$env = new Env();
$env->load();

$config = require __DIR__ . '/../../config/database.php';

$database = new Database($config);
$pdo = $database->getConnection();

$userRepository = new UserRepository($pdo);

$name = 'Lawyer Abdelrahman Karam';
$email = 'Lawyer@lawfirm.test';
$password = 'Lawyer@12345';
$role = 'lawyer';
$status = 'active';

$hashedPassword = password_hash($password, PASSWORD_DEFAULT);

try {
    $userId = $userRepository->create(
        $name,
        $email,
        $hashedPassword,
        $role,
        $status
    );

    echo "Admin created successfully. ID: {$userId}";
} catch (\PDOException $e) {
    echo "Failed to create admin.";
}