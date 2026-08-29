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

}