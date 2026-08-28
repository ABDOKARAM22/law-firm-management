<?php

namespace LawFirmManagement\Controllers;

use LawFirmManagement\Core\Auth;
use LawFirmManagement\Core\Authorization;

class DashboardController
{
    public function __construct(
        private Auth $auth,
        private Authorization $authorization
    ) {
    }

    public function index(): void
    {

        $user = $this->auth->user();

        require __DIR__ . '/../Views/dashboard/index.php';
    }
}