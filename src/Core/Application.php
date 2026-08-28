<?php

namespace LawFirmManagement\Core;

use LawFirmManagement\Repositories\UserRepository;
use LawFirmManagement\Controllers\AuthController;

class Application
{
    public function run(): void
    {
        $env = new Env();
        $env->load();

        $config = require __DIR__ . '/../../config/database.php';

        $database = new Database($config);

        $userRepository = new UserRepository(
            $database->getConnection()
        );

        $auth = new Auth($userRepository);

        $controller = new AuthController($auth);

        $router = new Router($controller);

        $route = $_GET['route'] ?? '';

        $router->dispatch($route);
    }
}