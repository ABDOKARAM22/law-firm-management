<?php

namespace LawFirmManagement\Core;

use LawFirmManagement\Controllers\AuthController;
use LawFirmManagement\Controllers\DashboardController;
use LawFirmManagement\Controllers\UsersController;
use LawFirmManagement\Controllers\ClientController;
use LawFirmManagement\Controllers\CaseController;

use LawFirmManagement\Middleware\AuthMiddleware;
use LawFirmManagement\Middleware\RoleMiddleware;

use LawFirmManagement\Repositories\UserRepository;
use LawFirmManagement\Repositories\ClientRepository;
use LawFirmManagement\Repositories\CaseRepository;
use LawFirmManagement\Repositories\CaseTypeRepository;
use LawFirmManagement\Repositories\CaseStatusHistoryRepository;

use LawFirmManagement\Services\UserService;
use LawFirmManagement\Services\ClientService;
use LawFirmManagement\Services\CaseService;

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

        // Get PDO connection
        $pdo = $database->getConnection();

        // Repositories
        $userRepository = new UserRepository($pdo);

        $clientRepository = new ClientRepository($pdo);

        $caseRepository = new CaseRepository($pdo);

        $caseTypeRepository = new CaseTypeRepository($pdo);

        $caseStatusHistoryRepository =
            new CaseStatusHistoryRepository($pdo);

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

        $caseService = new CaseService(
            $caseRepository,
            $clientRepository,
            $userRepository,
            $caseTypeRepository,
            $caseStatusHistoryRepository,
            $pdo
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

        $caseController = new CaseController(
            $caseService,
            $clientService,
            $userRepository,
            $caseTypeRepository,
            $auth
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
            $caseController,
            $authMiddleware,
            $roleMiddleware
        );

        // Dispatch route
        $route = $_GET['route'] ?? '';

        $router->dispatch($route);
    }
}