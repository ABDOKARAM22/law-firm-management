<?php

namespace LawFirmManagement\Repositories;

use PDO;

class DocumentRepository
{
    public function __construct(
        private PDO $pdo
    ) {
    }

    public function create(
        int $caseId,
        string $title,
        string $fileName,
        string $filePath,
        string $fileType,
        int $fileSize,
        int $uploadedBy
    ): int {
        $statement = $this->pdo->prepare(
            'INSERT INTO documents (
                case_id,
                title,
                file_name,
                file_path,
                file_type,
                file_size,
                uploaded_by
            )
            VALUES (
                :case_id,
                :title,
                :file_name,
                :file_path,
                :file_type,
                :file_size,
                :uploaded_by
            )'
        );

        $statement->execute([
            'case_id' => $caseId,
            'title' => $title,
            'file_name' => $fileName,
            'file_path' => $filePath,
            'file_type' => $fileType,
            'file_size' => $fileSize,
            'uploaded_by' => $uploadedBy,
        ]);

        return (int) $this->pdo->lastInsertId();
    }



    public function findById(int $id): array|false
    {
        $statement = $this->pdo->prepare(
            'SELECT
                documents.*,
                cases.case_number,
                cases.title AS case_title,
                users.name AS uploaded_by_name
            FROM documents
            INNER JOIN cases
                ON cases.id = documents.case_id
            INNER JOIN users
                ON users.id = documents.uploaded_by
            WHERE documents.id = :id'
        );

        $statement->execute([
            'id' => $id,
        ]);

        $document = $statement->fetch();

        return $document ?: false;
    }



    public function allByCaseId(int $caseId): array
    {
        $statement = $this->pdo->prepare(
            'SELECT
                documents.*,
                users.name AS uploaded_by_name
            FROM documents
            INNER JOIN users
                ON users.id = documents.uploaded_by
            WHERE documents.case_id = :case_id
            ORDER BY documents.created_at DESC'
        );

        $statement->execute([
            'case_id' => $caseId,
        ]);

        return $statement->fetchAll();
    }


    public function update(
    int $id,
    string $title,
    string $fileName,
    string $filePath,
    string $fileType,
    int $fileSize
    ): void {
        $statement = $this->pdo->prepare(
            'UPDATE documents
            SET
                title = :title,
                file_name = :file_name,
                file_path = :file_path,
                file_type = :file_type,
                file_size = :file_size
            WHERE id = :id'
        );

        $statement->execute([
            'id' => $id,
            'title' => $title,
            'file_name' => $fileName,
            'file_path' => $filePath,
            'file_type' => $fileType,
            'file_size' => $fileSize,
        ]);
    }


    public function delete(int $id): void
    {
        $statement = $this->pdo->prepare(
            'DELETE FROM documents
            WHERE id = :id'
        );

        $statement->execute([
            'id' => $id,
        ]);
    }

    
}