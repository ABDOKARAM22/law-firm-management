<?php

require_once __DIR__ . '/../../vendor/autoload.php';

use LawFirmManagement\Core\Env;
use LawFirmManagement\Core\Database;
use LawFirmManagement\Repositories\ClientRepository;

$env = new Env();
$env->load();

$config = require __DIR__ . '/../../config/database.php';

$database = new Database($config);
$pdo = $database->getConnection();

$clientRepository = new ClientRepository($pdo);

$name = 'Ahmed Mohamed';
$nationalId = '12345678901234';
$phone = '01000000000';
$email = 'ahmed@example.com';
$address = 'Cairo, Egypt';
$status = 'active';

try {

    $clientId = $clientRepository->create(
        $name,
        $nationalId,
        $phone,
        $email,
        $address,
        $status
    );

    echo "Client created successfully. ID: {$clientId}";

} catch (\PDOException $e) {

    echo "Failed to create client.";

}