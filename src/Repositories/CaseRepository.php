<?php

namespace LawFirmManagement\Repositories;

use PDO;

class CaseRepository
{
    public function __construct(
        private PDO $pdo
    ) {
    }

    public function all(): array
    {
        $statement = $this->pdo->query(
            'SELECT
                cases.*,
                clients.name AS client_name,
                users.name AS lawyer_name,
                case_types.name AS case_type_name
             FROM cases
             INNER JOIN clients
                ON clients.id = cases.client_id
             INNER JOIN users
                ON users.id = cases.assigned_lawyer_id
             INNER JOIN case_types
                ON case_types.id = cases.case_type_id
             ORDER BY cases.id DESC'
        );

        return $statement->fetchAll();
    }



    public function allByLawyerId(int $lawyerId): array
    {
        $statement = $this->pdo->prepare(
            'SELECT
                cases.*,
                clients.name AS client_name,
                users.name AS lawyer_name,
                case_types.name AS case_type_name
            FROM cases
            INNER JOIN clients
                ON clients.id = cases.client_id
            INNER JOIN users
                ON users.id = cases.assigned_lawyer_id
            INNER JOIN case_types
                ON case_types.id = cases.case_type_id
            WHERE cases.assigned_lawyer_id = :lawyer_id
            ORDER BY cases.id DESC'
        );

        $statement->execute([
            'lawyer_id' => $lawyerId,
        ]);

        return $statement->fetchAll();
    }




    public function findById(int $id): array|false
    {
        $statement = $this->pdo->prepare(
            'SELECT
                cases.*,
                clients.name AS client_name,
                users.name AS lawyer_name,
                case_types.name AS case_type_name
             FROM cases
             INNER JOIN clients
                ON clients.id = cases.client_id
             INNER JOIN users
                ON users.id = cases.assigned_lawyer_id
             INNER JOIN case_types
                ON case_types.id = cases.case_type_id
             WHERE cases.id = :id
             LIMIT 1'
        );

        $statement->execute([
            'id' => $id,
        ]);

        return $statement->fetch();
    }

    public function create(
        string $caseNumber,
        string $title,
        int $clientId,
        int $assignedLawyerId,
        int $caseTypeId,
        string $courtName,
        ?string $courtNumber,
        string $status,
        ?string $description,
        ?string $filingDate
    ): int  {
        $statement = $this->pdo->prepare(
            'INSERT INTO cases (
                case_number,
                title,
                client_id,
                assigned_lawyer_id,
                case_type_id,
                court_name,
                court_number,
                status,
                description,
                filing_date
             )
             VALUES (
                :case_number,
                :title,
                :client_id,
                :assigned_lawyer_id,
                :case_type_id,
                :court_name,
                :court_number,
                :status,
                :description,
                :filing_date
             )'
        );

        $statement->execute([
            'case_number' => $caseNumber,
            'title' => $title,
            'client_id' => $clientId,
            'assigned_lawyer_id' => $assignedLawyerId,
            'case_type_id' => $caseTypeId,
            'court_name' => $courtName,
            'court_number' => $courtNumber,
            'status' => $status,
            'description' => $description,
            'filing_date' => $filingDate,
        ]);

        return (int) $this->pdo->lastInsertId();
    }

    public function update(
        int $id,
        string $caseNumber,
        string $title,
        int $clientId,
        int $assignedLawyerId,
        int $caseTypeId,
        string $courtName,
        ?string $courtNumber,
        string $status,
        ?string $description,
        ?string $filingDate
    ): bool {
        $statement = $this->pdo->prepare(
            'UPDATE cases
             SET case_number = :case_number,
                 title = :title,
                 client_id = :client_id,
                 assigned_lawyer_id = :assigned_lawyer_id,
                 case_type_id = :case_type_id,
                 court_name = :court_name,
                 court_number = :court_number,
                 status = :status,
                 description = :description,
                 filing_date = :filing_date
             WHERE id = :id'
        );

        return $statement->execute([
            'id' => $id,
            'case_number' => $caseNumber,
            'title' => $title,
            'client_id' => $clientId,
            'assigned_lawyer_id' => $assignedLawyerId,
            'case_type_id' => $caseTypeId,
            'court_name' => $courtName,
            'court_number' => $courtNumber,
            'status' => $status,
            'description' => $description,
            'filing_date' => $filingDate,
        ]);
    }

    public function findByCaseNumber(
        string $caseNumber
    ): array|false {
        $statement = $this->pdo->prepare(
            'SELECT *
             FROM cases
             WHERE case_number = :case_number
             LIMIT 1'
        );

        $statement->execute([
            'case_number' => $caseNumber,
        ]);

        return $statement->fetch();
    }

    public function existsByCaseNumber(
        string $caseNumber
    ): bool {
        $statement = $this->pdo->prepare(
            'SELECT 1
             FROM cases
             WHERE case_number = :case_number
             LIMIT 1'
        );

        $statement->execute([
            'case_number' => $caseNumber,
        ]);

        return $statement->fetch() !== false;
    }

    public function existsByCaseNumberExceptId(
        string $caseNumber,
        int $id
    ): bool {
        $statement = $this->pdo->prepare(
            'SELECT 1
             FROM cases
             WHERE case_number = :case_number
             AND id != :id
             LIMIT 1'
        );

        $statement->execute([
            'case_number' => $caseNumber,
            'id' => $id,
        ]);

        return $statement->fetch() !== false;
    }
}