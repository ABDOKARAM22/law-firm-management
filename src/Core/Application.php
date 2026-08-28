<?php

namespace LawFirmManagement\Core;

use LawFirmManagement\Controllers\AuthController;
use LawFirmManagement\Controllers\DashboardController;
use LawFirmManagement\Repositories\UserRepository;

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

        $authController = new AuthController($auth);

        $dashboardController = new DashboardController($auth);

        $router = new Router(
            $authController,
            $dashboardController
        );

        $route = $_GET['route'] ?? '';

        $router->dispatch($route);
    }
}