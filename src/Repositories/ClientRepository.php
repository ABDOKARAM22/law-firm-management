<?php

namespace LawFirmManagement\Repositories;

use PDO;

class ClientRepository
{
    public function __construct(
        private PDO $pdo
    ) {
    }

    public function all(): array
    {
        $statement = $this->pdo->query(
            'SELECT *
             FROM clients
             ORDER BY id DESC'
        );

        return $statement->fetchAll();
    }

    public function findById(int $id): array|false
    {
        $statement = $this->pdo->prepare(
            'SELECT *
             FROM clients
             WHERE id = :id
             LIMIT 1'
        );

        $statement->execute([
            'id' => $id,
        ]);

        return $statement->fetch();
    }

    public function create(
        string $name,
        string $nationalId,
        string $phone,
        ?string $email,
        ?string $address,
        string $status
    ): bool {
        $statement = $this->pdo->prepare(
            'INSERT INTO clients
                (name, national_id, phone, email, address, status)
             VALUES
                (:name, :national_id, :phone, :email, :address, :status)'
        );

        return $statement->execute([
            'name' => $name,
            'national_id' => $nationalId,
            'phone' => $phone,
            'email' => $email,
            'address' => $address,
            'status' => $status,
        ]);
    }

    public function update(
        int $id,
        string $name,
        string $nationalId,
        string $phone,
        ?string $email,
        ?string $address,
        string $status
    ): bool {
        $statement = $this->pdo->prepare(
            'UPDATE clients
             SET name = :name,
                 national_id = :national_id,
                 phone = :phone,
                 email = :email,
                 address = :address,
                 status = :status
             WHERE id = :id'
        );

        return $statement->execute([
            'id' => $id,
            'name' => $name,
            'national_id' => $nationalId,
            'phone' => $phone,
            'email' => $email,
            'address' => $address,
            'status' => $status,
        ]);
    }

    public function existsByNationalId(
        string $nationalId
    ): bool {
        $statement = $this->pdo->prepare(
            'SELECT 1
             FROM clients
             WHERE national_id = :national_id
             LIMIT 1'
        );

        $statement->execute([
            'national_id' => $nationalId,
        ]);

        return $statement->fetch() !== false;
    }

    public function existsByNationalIdExceptId(
        string $nationalId,
        int $id
    ): bool {
        $statement = $this->pdo->prepare(
            'SELECT 1
             FROM clients
             WHERE national_id = :national_id
             AND id != :id
             LIMIT 1'
        );

        $statement->execute([
            'national_id' => $nationalId,
            'id' => $id,
        ]);

        return $statement->fetch() !== false;
    }


    public function existsByEmail(string $email): bool
    {
        $statement = $this->pdo->prepare(
            'SELECT 1
            FROM clients
            WHERE email = :email
            LIMIT 1'
        );

        $statement->execute([
            'email' => $email,
        ]);

        return $statement->fetch() !== false;
    }


    public function existsByEmailExceptId(
    string $email,
    int $id
    ): bool {
        $statement = $this->pdo->prepare(
            'SELECT 1
            FROM clients
            WHERE email = :email
            AND id != :id
            LIMIT 1'
        );

        $statement->execute([
            'email' => $email,
            'id' => $id,
        ]);

        return $statement->fetch() !== false;
    }

}