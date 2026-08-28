<?php

namespace LawFirmManagement\Core;

use LawFirmManagement\Controllers\AuthController;
use LawFirmManagement\Controllers\DashboardController;

class Router
{
    public function __construct(
        private AuthController $authController,
        private DashboardController $dashboardController
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

            case 'dashboard':
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