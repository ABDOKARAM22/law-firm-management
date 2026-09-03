<?php

namespace LawFirmManagement\Core;

use LawFirmManagement\Controllers\AppointmentController;
use LawFirmManagement\Controllers\AuthController;
use LawFirmManagement\Controllers\DashboardController;
use LawFirmManagement\Controllers\UsersController;
use LawFirmManagement\Controllers\ClientController;
use LawFirmManagement\Controllers\CaseController;
use LawFirmManagement\Controllers\DocumentController;
use LawFirmManagement\Controllers\HearingController;
use LawFirmManagement\Middleware\AuthMiddleware;
use LawFirmManagement\Middleware\RoleMiddleware;
use LawFirmManagement\Repositories\AppointmentRepository;
use LawFirmManagement\Repositories\UserRepository;
use LawFirmManagement\Repositories\ClientRepository;
use LawFirmManagement\Repositories\CaseRepository;
use LawFirmManagement\Repositories\CaseTypeRepository;
use LawFirmManagement\Repositories\CaseStatusHistoryRepository;
use LawFirmManagement\Repositories\DocumentRepository;
use LawFirmManagement\Repositories\HearingRepository;
use LawFirmManagement\Services\AppointmentAccessService;
use LawFirmManagement\Services\AppointmentService;
use LawFirmManagement\Services\UserService;
use LawFirmManagement\Services\ClientService;
use LawFirmManagement\Services\CaseService;
use LawFirmManagement\Services\HearingService;
use LawFirmManagement\Services\CaseAccessService;
use LawFirmManagement\Services\DocumentService;

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

        $caseStatusHistoryRepository = new CaseStatusHistoryRepository($pdo);

        $hearingRepository = new HearingRepository($pdo);

        $appointmentRepository = new AppointmentRepository($pdo);
        
        $documentRepository = new DocumentRepository($pdo); 

        // Authentication
        $auth = new Auth($userRepository);


        
        $caseAccessService = new CaseAccessService(
            $caseRepository,
            $auth
        );

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

        $hearingService = new HearingService(
            $hearingRepository,
            $caseRepository
        );

        $appointmentservice = new AppointmentService(
            $appointmentRepository,
            $clientRepository,
            $userRepository
        );

        $appointmentAccessService = new AppointmentAccessService(
            $appointmentRepository,
            $auth
        );

        $documentservice = new DocumentService(
            $documentRepository,
            $caseRepository,
            $auth,
            $caseAccessService
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
            $auth,
            $hearingService,
            $caseAccessService
            );
            
            $hearingController = new HearingController(
            $hearingService,
            $caseService,
            $auth,
            $caseAccessService
            ); 


            $appointmentController = new AppointmentController(
                $appointmentservice,
                $clientService,
                $userRepository,
                $appointmentAccessService,
                $auth
            );


            $documentController = new DocumentController(
                $documentservice,
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
            $hearingController,
            $appointmentController,
            $documentController,
            $authMiddleware,
            $roleMiddleware
        );

        // Dispatch route
        $route = $_GET['route'] ?? '';

        $router->dispatch($route);
    }
}