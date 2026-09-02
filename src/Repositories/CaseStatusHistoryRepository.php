<?php

namespace LawFirmManagement\Repositories;

use PDO;

class CaseStatusHistoryRepository
{
    public function __construct(
        private PDO $pdo
    ) {
    }

    public function create(
        int $caseId,
        ?string $oldStatus,
        string $newStatus,
        int $changedBy
    ): bool {
        $statement = $this->pdo->prepare(
            'INSERT INTO case_status_history (
                case_id,
                old_status,
                new_status,
                changed_by
             )
             VALUES (
                :case_id,
                :old_status,
                :new_status,
                :changed_by
             )'
        );

        return $statement->execute([
            'case_id' => $caseId,
            'old_status' => $oldStatus,
            'new_status' => $newStatus,
            'changed_by' => $changedBy,
        ]);
    }
}