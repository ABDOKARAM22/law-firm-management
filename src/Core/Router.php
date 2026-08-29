<?php

namespace LawFirmManagement\Core;

use LawFirmManagement\Controllers\AuthController;
use LawFirmManagement\Controllers\ClientController;
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
        private ClientController $clientController,
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


            case 'users/edit':
            $this->authMiddleware->handle();
            $this->roleMiddleware->handle('admin');
            
            if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                $this->usersController->update();
            } else {
                $this->usersController->edit();
            }
            break;
                
            case 'dashboard':
                $this->authMiddleware->handle();

                $this->dashboardController->index();
                break;

            case 'clients':

                $this->authMiddleware->handle();

                $clients = $this->clientController->index();

            break;
            
            

            case 'clients/create':

                $this->authMiddleware->handle();
                $this->roleMiddleware->handle('admin');

                if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                    $this->clientController->store();
                } else {
                    $this->clientController->create();
                }

            break;
                
            case 'clients/edit':

            $this->authMiddleware->handle();
            $this->roleMiddleware->handle('admin');

            if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                $this->clientController->update();
            } else {
                $this->clientController->edit();
            }

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