<?php

namespace LawFirmManagement\Repositories;

use PDO;

class AppointmentRepository
{
    public function __construct(
        private PDO $pdo
    ) {
    }

    public function create(
        ?int $clientId,
        int $assignedUserId,
        string $appointmentDate,
        string $appointmentTime,
        string $title,
        string $type,
        string $status,
        ?string $notes
    ): int {
        $statement = $this->pdo->prepare(
            'INSERT INTO appointments (
                client_id,
                assigned_user_id,
                appointment_date,
                appointment_time,
                title,
                type,
                status,
                notes
            )
            VALUES (
                :client_id,
                :assigned_user_id,
                :appointment_date,
                :appointment_time,
                :title,
                :type,
                :status,
                :notes
            )'
        );

        $statement->execute([
            'client_id' => $clientId,
            'assigned_user_id' => $assignedUserId,
            'appointment_date' => $appointmentDate,
            'appointment_time' => $appointmentTime,
            'title' => $title,
            'type' => $type,
            'status' => $status,
            'notes' => $notes,
        ]);

        return (int) $this->pdo->lastInsertId();
    }

    public function all(): array
    {
        $statement = $this->pdo->prepare(
            'SELECT
                appointments.*,
                clients.name AS client_name,
                users.name AS assigned_user_name
            FROM appointments
            LEFT JOIN clients
                ON clients.id = appointments.client_id
            INNER JOIN users
                ON users.id = appointments.assigned_user_id
            ORDER BY
                appointments.appointment_date DESC,
                appointments.appointment_time DESC'
        );

        $statement->execute();

        return $statement->fetchAll();
    }


   public function findById(int $id): array|false
    {
        $statement = $this->pdo->prepare(
            'SELECT
                appointments.*,
                clients.name AS client_name,
                users.name AS assigned_user_name
            FROM appointments
            LEFT JOIN clients
                ON clients.id = appointments.client_id
            INNER JOIN users
                ON users.id = appointments.assigned_user_id
            WHERE appointments.id = :id'
        );

        $statement->execute([
            'id' => $id,
        ]);

        $appointment = $statement->fetch();

        return $appointment ?: false;
    }



    public function allByAssignedUserId(int $userId): array
    {
        $statement = $this->pdo->prepare(
            'SELECT
                appointments.*,
                clients.name AS client_name,
                users.name AS assigned_user_name
            FROM appointments
            LEFT JOIN clients
                ON clients.id = appointments.client_id
            INNER JOIN users
                ON users.id = appointments.assigned_user_id
            WHERE appointments.assigned_user_id = :user_id
            ORDER BY
                appointments.appointment_date DESC,
                appointments.appointment_time DESC'
        );

        $statement->execute([
            'user_id' => $userId,
        ]);

        return $statement->fetchAll();
    }

}