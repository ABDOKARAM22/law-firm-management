<?php

namespace LawFirmManagement\Repositories;

use PDO;

class HearingRepository
{
    public function __construct(
        private PDO $pdo
    ) {
    }

    public function create(
        int $caseId,
        string $hearingDate,
        string $hearingTime,
        string $courtName,
        ?string $courtNumber,
        string $hearingType,
        string $status,
        ?string $notes
    ): int {
        $statement = $this->pdo->prepare(
            'INSERT INTO hearings (
                case_id,
                hearing_date,
                hearing_time,
                court_name,
                court_number,
                hearing_type,
                status,
                notes
             )
             VALUES (
                :case_id,
                :hearing_date,
                :hearing_time,
                :court_name,
                :court_number,
                :hearing_type,
                :status,
                :notes
             )'
        );

        $statement->execute([
            'case_id' => $caseId,
            'hearing_date' => $hearingDate,
            'hearing_time' => $hearingTime,
            'court_name' => $courtName,
            'court_number' => $courtNumber,
            'hearing_type' => $hearingType,
            'status' => $status,
            'notes' => $notes,
        ]);

        return (int) $this->pdo->lastInsertId();
    }

    public function allByCaseId(int $caseId): array
    {
        $statement = $this->pdo->prepare(
            'SELECT *
             FROM hearings
             WHERE case_id = :case_id
             ORDER BY hearing_date DESC, hearing_time DESC'
        );

        $statement->execute([
            'case_id' => $caseId,
        ]);

        return $statement->fetchAll();
    }



    public function findById(int $id): array|false
        {
            $statement = $this->pdo->prepare(
                'SELECT *
                FROM hearings
                WHERE id = :id'
            );

            $statement->execute([
                'id' => $id,
            ]);

            $hearing = $statement->fetch();

            return $hearing ?: false;
        }



    public function update(
        int $id,
        string $hearingDate,
        string $hearingTime,
        string $courtName,
        ?string $courtNumber,
        string $hearingType,
        string $status,
        ?string $notes
        ): bool {
        $statement = $this->pdo->prepare(
            'UPDATE hearings
            SET
                hearing_date = :hearing_date,
                hearing_time = :hearing_time,
                court_name = :court_name,
                court_number = :court_number,
                hearing_type = :hearing_type,
                status = :status,
                notes = :notes
            WHERE id = :id'
        );

        return $statement->execute([
            'id' => $id,
            'hearing_date' => $hearingDate,
            'hearing_time' => $hearingTime,
            'court_name' => $courtName,
            'court_number' => $courtNumber,
            'hearing_type' => $hearingType,
            'status' => $status,
            'notes' => $notes,
        ]);
    }


}