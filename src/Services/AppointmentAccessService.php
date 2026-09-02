<?php

namespace LawFirmManagement\Services;

use LawFirmManagement\Core\Auth;
use LawFirmManagement\Repositories\AppointmentRepository;

class AppointmentAccessService
{
    public function __construct(
        private AppointmentRepository $appointmentRepository,
        private Auth $auth
    ) {}

    public function canAccess(int $appointmentId): bool
    {
        $appointment = $this->appointmentRepository->findById($appointmentId);

        if ($appointment === false) {
            return false;
        }

        $user = $this->auth->user();

        if ($user === null) {
            return false;
        }

        // Admin and Staff can access all appointments.
        if (in_array($user['role'], ['admin', 'staff'], true)) {
            return true;
        }

        // Lawyer can access only appointments assigned to them.
        if (
            $user['role'] === 'lawyer' &&
            (int)$appointment['assigned_user_id'] === (int)$user['id']
        ) {
            return true;
        }

        return false;
    }

    public function accessibleAppointments(): array
    {
        $user = $this->auth->user();

        if ($user === null) {
            return [];
        }

        if (in_array($user['role'], ['admin', 'staff'], true)) {
            return $this->appointmentRepository->all();
        }

        if ($user['role'] === 'lawyer') {
            return $this->appointmentRepository->allByAssignedUserId(
                (int)$user['id']
            );
        }

        return [];
    }
}