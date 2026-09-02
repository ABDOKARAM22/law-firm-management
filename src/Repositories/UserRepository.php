<?php

namespace LawFirmManagement\Repositories;

use PDO;

class UserRepository
{
    private PDO $db;

    public function __construct(PDO $db)
    {
        $this->db = $db;
    }

    public function all(): array
    {
        $statement = $this->db->prepare(
            'SELECT id, name, email, role, status, created_at, updated_at
            FROM users
            ORDER BY id DESC'
        );

        $statement->execute();

        return $statement->fetchAll();
    }

    

    public function findByEmail(string $email): ?array
    {
        $sql = "SELECT * FROM users WHERE email = :email LIMIT 1";

        $stmt = $this->db->prepare($sql);
        $stmt->execute([
            'email' => $email
        ]);

        $user = $stmt->fetch();

        return $user ?: null;
    }

    public function findById(int $id): ?array
    {
        $sql = "SELECT * FROM users WHERE id = :id LIMIT 1";

        $stmt = $this->db->prepare($sql);
        $stmt->execute([
            'id' => $id
        ]);

        $user = $stmt->fetch();

        return $user ?: null;
    }

    
    public function create(
        string $name,
        string $email,
        string $password,
        string $role,
        string $status
    ): bool {
        $statement = $this->db->prepare(
            'INSERT INTO users
            (name, email, password, role, status)
            VALUES
            (:name, :email, :password, :role, :status)'
        );

        return $statement->execute([
            'name' => $name,
            'email' => $email,
            'password' => $password,
            'role' => $role,
            'status' => $status,
        ]);
    }


    public function existsByEmailExceptId(
        string $email,
        int $userId
    ): bool {
        $statement = $this->db->prepare(
            'SELECT 1
            FROM users
            WHERE email = :email
            AND id != :id
            LIMIT 1'
        );

        $statement->execute([
            'email' => $email,
            'id' => $userId,
        ]);

        return $statement->fetch() !== false;
    }

    public function update(
        int $id,
        string $name,
        string $email,
        string $role,
        string $status
    ): bool {
        $statement = $this->db->prepare(
            'UPDATE users
            SET name = :name,
                email = :email,
                role = :role,
                status = :status
            WHERE id = :id'
        );

        return $statement->execute([
            'id' => $id,
            'name' => $name,
            'email' => $email,
            'role' => $role,
            'status' => $status,
        ]);
    }



    public function findActiveLawyerById(
    int $id
    ): array|false {
        $statement = $this->db->prepare(
            'SELECT *
            FROM users
            WHERE id = :id
            AND role = :role
            AND status = :status
            LIMIT 1'
        );

        $statement->execute([
            'id' => $id,
            'role' => 'lawyer',
            'status' => 'active',
        ]);

        return $statement->fetch();
    }


    public function allActiveLawyers(): array
    {
        $statement = $this->db->prepare(
            'SELECT id, name
            FROM users
            WHERE role = :role
            AND status = :status
            ORDER BY name ASC'
        );

        $statement->execute([
            'role' => 'lawyer',
            'status' => 'active',
        ]);

        return $statement->fetchAll();
    }

}