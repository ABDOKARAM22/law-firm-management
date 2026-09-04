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

    public function search(
        string $search = '',
        ?string $status = null,
        ?int $caseTypeId = null,
        ?int $lawyerId = null,
        int $limit = 10,
        int $offset = 0
    ): array {
        $user = $this->auth->user();

        if ($user === null) {
            return [];
        }

        // Lawyer can only search within assigned cases
        if ($user['role'] === 'lawyer') {
            $lawyerId = (int) $user['id'];
        }

        return $this->caseRepository->search(
            $search,
            $status,
            $caseTypeId,
            $lawyerId,
            $limit,
            $offset
        );
    }

    public function countSearchResults(
        string $search = '',
        ?string $status = null,
        ?int $caseTypeId = null,
        ?int $lawyerId = null
    ): int {
        $user = $this->auth->user();

        if ($user === null) {
            return 0;
        }

        // Lawyer can only count results from assigned cases
        if ($user['role'] === 'lawyer') {
            $lawyerId = (int) $user['id'];
        }

        return $this->caseRepository->countSearchResults(
            $search,
            $status,
            $caseTypeId,
            $lawyerId
        );
    }
}