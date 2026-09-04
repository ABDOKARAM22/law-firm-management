<?php

namespace LawFirmManagement\Core;

use LawFirmManagement\Controllers\AppointmentController;
use LawFirmManagement\Controllers\AuthController;
use LawFirmManagement\Controllers\CaseController;
use LawFirmManagement\Controllers\ClientController;
use LawFirmManagement\Controllers\DashboardController;
use LawFirmManagement\Controllers\DocumentController;
use LawFirmManagement\Controllers\HearingController;
use LawFirmManagement\Controllers\UsersController;
use LawFirmManagement\Middleware\AuthMiddleware;
use LawFirmManagement\Middleware\RoleMiddleware;
use LawFirmManagement\Repositories\AppointmentRepository;
use LawFirmManagement\Repositories\CaseRepository;
use LawFirmManagement\Repositories\CaseStatusHistoryRepository;
use LawFirmManagement\Repositories\CaseTypeRepository;
use LawFirmManagement\Repositories\ClientRepository;
use LawFirmManagement\Repositories\DashboardRepository;
use LawFirmManagement\Repositories\DocumentRepository;
use LawFirmManagement\Repositories\HearingRepository;
use LawFirmManagement\Repositories\UserRepository;
use LawFirmManagement\Services\AppointmentAccessService;
use LawFirmManagement\Services\AppointmentService;
use LawFirmManagement\Services\CaseAccessService;
use LawFirmManagement\Services\CaseService;
use LawFirmManagement\Services\ClientService;
use LawFirmManagement\Services\DashboardService;
use LawFirmManagement\Services\DocumentService;
use LawFirmManagement\Services\HearingService;
use LawFirmManagement\Services\UserService;

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

        $dashboardRepository = new DashboardRepository($pdo);

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


        $dashboardService = new DashboardService(
            $dashboardRepository
            );

        // Authorization
        $authorization = new Authorization($auth);


        // Controllers
        $authController = new AuthController($auth);

        $dashboardController = new DashboardController(
            $auth,
            $authorization,
            $dashboardService
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