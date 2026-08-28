<?php

namespace LawFirmManagement\Core;

use LawFirmManagement\Controllers\AuthController;

class Router
{
    public function __construct(
        private AuthController $authController
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

            default:
                http_response_code(404);
                echo '404 - Page Not Found';
        }
    }
}