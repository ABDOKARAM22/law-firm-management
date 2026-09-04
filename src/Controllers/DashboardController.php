<?php

namespace LawFirmManagement\Controllers;

use LawFirmManagement\Core\Auth;
use LawFirmManagement\Core\Authorization;
use LawFirmManagement\Services\DashboardService;

class DashboardController
{
    public function __construct(
        private Auth $auth,
        private Authorization $authorization,
        private DashboardService $dashboardService
    ) {
    }

    public function index(): void
    {

    
        $user = $this->auth->user();

        $stats = [];

        switch ($user['role']) {
            case 'admin':
                $stats = $this->dashboardService->getAdminStats();
                break;

            case 'staff':
                $stats = $this->dashboardService->getStaffStats();
                break;

            case 'lawyer':
                $stats = $this->dashboardService->getLawyerStats(
                    (int) $user['id']
                );
                break;
        }
        require __DIR__ . '/../Views/dashboard/index.php';
    }
}