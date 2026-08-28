<?php

namespace LawFirmManagement\Controllers;

use LawFirmManagement\Core\Auth;

class DashboardController
{
    public function __construct(
        private Auth $auth
    ) {
    }

    public function index(): void
    {
        if (!$this->auth->check()) {
            header('Location: ?route=login');
            exit;
        }

        $user = $this->auth->user();

        require __DIR__ . '/../Views/dashboard/index.php';
    }
}