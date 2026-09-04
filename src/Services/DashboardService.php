<?php

namespace LawFirmManagement\Services;

use LawFirmManagement\Repositories\DashboardRepository;

class DashboardService
{
    public function __construct(
        private DashboardRepository $dashboardRepository
    ) {
    }

    private array $caseStatuses = [
    'pending',
    'active',
    'on_hold',
    'closed',
];


    private function formatCasesByStatus(array $casesByStatus): array
    {
        $result = array_fill_keys($this->caseStatuses, 0);

        foreach ($casesByStatus as $case) {
            $status = $case['status'];

            if (isset($result[$status])) {
                $result[$status] = (int) $case['total'];
            }
        }

        return $result;
    }

    public function getAdminStats(): array
    {
        return [
            'clients_count' => $this->dashboardRepository->countClients(),
            'cases_count' => $this->dashboardRepository->countCases(),
            'lawyers_count' => $this->dashboardRepository->countLawyers(),
            'staff_count' => $this->dashboardRepository->countStaff(),
            'cases_by_status' => $this->formatCasesByStatus(
                $this->dashboardRepository->countCasesByStatus()
            ),
            'upcoming_appointments' => $this->dashboardRepository->getUpcomingAppointments(),
            'upcoming_hearings' => $this->dashboardRepository->getUpcomingHearings(),
        ];
    }


    public function getStaffStats(): array
    {
        return [
            'clients_count' => $this->dashboardRepository->countClients(),
            'cases_count' => $this->dashboardRepository->countCases(),
            'cases_by_status' => $this->formatCasesByStatus(
                $this->dashboardRepository->countCasesByStatus()
            ),
            'upcoming_appointments' => $this->dashboardRepository->getUpcomingAppointments(),
            'upcoming_hearings' => $this->dashboardRepository->getUpcomingHearings(),

        ];
    }


    public function getLawyerStats(int $lawyerId): array
    {
        return [
            'cases_count' =>
                $this->dashboardRepository->countCasesByLawyerId($lawyerId),

            'cases_by_status' => $this->formatCasesByStatus(
                $this->dashboardRepository->countCasesByStatusForLawyer($lawyerId)
            ),

            'upcoming_appointments' => $this->dashboardRepository->getUpcomingAppointmentsForUser($lawyerId),
            'upcoming_hearings' => $this->dashboardRepository->getUpcomingHearingsForLawyer($lawyerId),

        ];
    }


}