<?php

namespace LawFirmManagement\Services;

use LawFirmManagement\Core\Auth;
use LawFirmManagement\Repositories\CaseRepository;

class CaseAccessService
{
    public function __construct(
        private CaseRepository $caseRepository,
        private Auth $auth
    ) {
    }

    public function canAccess(int $caseId): bool
    {
        $case = $this->caseRepository->findById($caseId);

        if ($case === false) {
            return false;
        }

        $user = $this->auth->user();

        if ($user === null) {
            return false;
        }

        // Admin and Staff can access all cases
        if (in_array($user['role'], ['admin', 'staff'], true)) {
            return true;
        }

        
        // Lawyer can access only assigned cases
        if (
            $user['role'] === 'lawyer' &&
            (int) $case['assigned_lawyer_id'] === (int) $user['id']
        ) {
            return true;
        }

        return false;
    }



        public function accessibleCases(): array
    {
        $user = $this->auth->user();

        if ($user === null) {
            return [];
        }

        if (in_array($user['role'], ['admin', 'staff'], true)) {
            return $this->caseRepository->all();
        }

        if ($user['role'] === 'lawyer') {
            return $this->caseRepository->allByLawyerId(
                (int) $user['id']
            );
        }

        return [];
    }
}