<?php

namespace LawFirmManagement\Core;

use LawFirmManagement\Controllers\AuthController;
use LawFirmManagement\Controllers\DashboardController;
use LawFirmManagement\Controllers\UsersController;
use LawFirmManagement\Middleware\AuthMiddleware;
use LawFirmManagement\Middleware\RoleMiddleware;

class Router
{
    public function __construct(
        private AuthController $authController,
        private DashboardController $dashboardController,
        private UsersController $usersController,
        private AuthMiddleware $authMiddleware,
        private RoleMiddleware $roleMiddleware
    ) {
    }

    public function dispatch(string $route): void
    {
        switch ($route) {

            case 'login':

                if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                    $this->authController->login();
                } else {
                    $this->authController->showLogin();
                }

                break;
            

            case 'users':
                $this->authMiddleware->handle();

                $this->roleMiddleware->handle('admin');

                $this->usersController->index();
                break;


            case 'users/create':
                $this->authMiddleware->handle();

                $this->roleMiddleware->handle('admin');

                if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                    $this->usersController->store();
                } else {
                    $this->usersController->create();
                }

                break;


            case 'dashboard':
                $this->authMiddleware->handle();

                $this->dashboardController->index();
                break;


            case 'logout':
                if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
                    http_response_code(405);
                    echo 'Method Not Allowed';
                    break;
                }

                $this->authController->logout();
                break;


            default:
                http_response_code(404);
                echo '404 - Page Not Found';
        }
    }
}