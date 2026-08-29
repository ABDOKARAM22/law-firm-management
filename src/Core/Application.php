<?php

namespace LawFirmManagement\Core;

use LawFirmManagement\Controllers\AuthController;
use LawFirmManagement\Controllers\DashboardController;
use LawFirmManagement\Controllers\UsersController;
use LawFirmManagement\Middleware\AuthMiddleware;
use LawFirmManagement\Middleware\RoleMiddleware;
use LawFirmManagement\Repositories\UserRepository;
use LawFirmManagement\Services\UserService;
use LawFirmManagement\Repositories\ClientRepository;
use LawFirmManagement\Services\ClientService;
use LawFirmManagement\Controllers\ClientController;

class Application
{
    public function run(): void
    {
        // Load environment variables
        $env = new Env();
        $env->load();

        // Database
        $config = require __DIR__ . '/../../config/database.php';

        $database = new Database($config);

        $userRepository = new UserRepository(
            $database->getConnection()
        );

        $clientRepository = new ClientRepository(
            $database->getConnection()
        );

        // Authentication
        $auth = new Auth($userRepository);

        // Services
        $userService = new UserService(
            $userRepository,
            $auth
        );

        $clientService = new ClientService(
         $clientRepository
        );
        

        // Authorization
        $authorization = new Authorization($auth);

        // Controllers
        $authController = new AuthController($auth);

        $dashboardController = new DashboardController(
            $auth,
            $authorization
        );

        $usersController = new UsersController(
            $userService
        );

         $clientController = new ClientController(
            $clientService
        );  

        // Middleware
        $authMiddleware = new AuthMiddleware($auth);
        $roleMiddleware = new RoleMiddleware($authorization);

        // Router
        $router = new Router(
            $authController,
            $dashboardController,
            $usersController,
            $clientController,
            $authMiddleware,
            $roleMiddleware
        );

        // Dispatch route
        $route = $_GET['route'] ?? '';

        $router->dispatch($route);
    }
}