<?php

namespace LawFirmManagement\Repositories;

use PDO;

class CaseTypeRepository
{
    public function __construct(
        private PDO $pdo
    ) {
    }

    public function all(): array
    {
        $statement = $this->pdo->prepare(
            'SELECT *
             FROM case_types
             WHERE status = :status
             ORDER BY name ASC'
        );

        $statement->execute([
            'status' => 'active',
        ]);

        return $statement->fetchAll();
    }

    public function findById(int $id): array|false
    {
        $statement = $this->pdo->prepare(
            'SELECT *
             FROM case_types
             WHERE id = :id
             AND status = :status
             LIMIT 1'
        );

        $statement->execute([
            'id' => $id,
            'status' => 'active',
        ]);

        return $statement->fetch();
    }
}