<?php

require_once __DIR__ . '/../vendor/autoload.php';

use LawFirmManagement\Core\Application;
use LawFirmManagement\Core\Env;
use LawFirmManagement\Core\Database;

$app = new Application();

$env = new Env();
$env->load();

$config = require __DIR__ . '/../config/database.php';


$database = new Database($config);

$pdo = $database->getConnection();

var_dump($pdo);