<?php

namespace LawFirmManagement\Core;

use LawFirmManagement\Controllers\AuthController;
use LawFirmManagement\Core\Authorization;
use LawFirmManagement\Middleware\AuthMiddleware;
use LawFirmManagement\Middleware\RoleMiddleware;
use LawFirmManagement\Controllers\DashboardController;
use LawFirmManagement\Controllers\UsersController;
use LawFirmManagement\Repositories\UserRepository;
use LawFirmManagement\Services\UserService;

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

        $userService = new UserService(
        $userRepository
        );

        $auth = new Auth($userRepository);

        $authController = new AuthController($auth);
        $authorization = new Authorization($auth);

        $authMiddleware = new AuthMiddleware($auth);
        $roleMiddleware = new RoleMiddleware($authorization);

        $dashboardController = new DashboardController($auth, $authorization);
        $usersController = new UsersController($userService);
        

        $router = new Router(
            $authController,
            $dashboardController,
             $usersController,
            $authMiddleware,
            $roleMiddleware
        );

        $route = $_GET['route'] ?? '';

        $router->dispatch($route);
    }
}