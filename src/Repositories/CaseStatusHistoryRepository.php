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


        public function allByCaseId(int $caseId): array
    {
        $statement = $this->pdo->prepare(
            'SELECT
                case_status_history.*,
                users.name AS changed_by_name
            FROM case_status_history
            INNER JOIN users
                ON users.id = case_status_history.changed_by
            WHERE case_status_history.case_id = :case_id
            ORDER BY case_status_history.id DESC'
        );

        $statement->execute([
            'case_id' => $caseId,
        ]);

        return $statement->fetchAll();
    }
}