<?php

namespace LawFirmManagement\Repositories;

use PDO;

class DashboardRepository
{
    public function __construct(
        private PDO $pdo
    ) {
    }

    public function countClients(): int
    {
        $stmt = $this->pdo->query(
            "SELECT COUNT(*) FROM clients"
        );

        return (int) $stmt->fetchColumn();
    }

    public function countCases(): int
    {
        $stmt = $this->pdo->query(
            "SELECT COUNT(*) FROM cases"
        );

        return (int) $stmt->fetchColumn();
    }

    public function countLawyers(): int
    {
        $stmt = $this->pdo->query(
            "SELECT COUNT(*) FROM users WHERE role = 'lawyer'"
        );

        return (int) $stmt->fetchColumn();
    }

    public function countStaff(): int
    {
        $stmt = $this->pdo->query(
            "SELECT COUNT(*) FROM users WHERE role = 'staff'"
        );

        return (int) $stmt->fetchColumn();
    }



    public function countCasesByStatus(): array
    {
        $stmt = $this->pdo->query(
            "SELECT status, COUNT(*) AS total
            FROM cases
            GROUP BY status"
        );

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }


    public function countCasesByLawyerId(int $lawyerId): int
    {
        $stmt = $this->pdo->prepare(
            "SELECT COUNT(*)
            FROM cases
            WHERE assigned_lawyer_id = :lawyer_id"
        );

        $stmt->execute([
            'lawyer_id' => $lawyerId,
        ]);

        return (int) $stmt->fetchColumn();
    }


    public function countCasesByStatusForLawyer(int $lawyerId): array
    {
        $stmt = $this->pdo->prepare(
            "SELECT status, COUNT(*) AS total
            FROM cases
            WHERE assigned_lawyer_id = :lawyer_id
            GROUP BY status"
        );

        $stmt->execute([
            'lawyer_id' => $lawyerId,
        ]);

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }


    public function getUpcomingAppointments(int $limit = 5): array
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
            WHERE appointments.status != "cancelled"
            AND CONCAT(
                appointments.appointment_date,
                " ",
                appointments.appointment_time
            ) >= NOW()
            ORDER BY
                appointments.appointment_date ASC,
                appointments.appointment_time ASC
            LIMIT :limit'
            );

        $statement->bindValue(':limit', $limit, PDO::PARAM_INT);

        $statement->execute();

        return $statement->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getUpcomingAppointmentsForUser(
    int $userId,
    int $limit = 5
    ): array {
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
            AND appointments.status != "cancelled"
            AND CONCAT(
                appointments.appointment_date,
                " ",
                appointments.appointment_time
            ) >= NOW()
            ORDER BY
                appointments.appointment_date ASC,
                appointments.appointment_time ASC
            LIMIT :limit'
        );

        $statement->bindValue(':user_id', $userId, PDO::PARAM_INT);
        $statement->bindValue(':limit', $limit, PDO::PARAM_INT);

        $statement->execute();

        return $statement->fetchAll(PDO::FETCH_ASSOC);
    }


    public function getUpcomingHearings(int $limit = 5): array
    {
        $statement = $this->pdo->prepare(
            'SELECT
                hearings.*,
                cases.case_number,
                clients.name AS client_name
            FROM hearings
            INNER JOIN cases
                ON cases.id = hearings.case_id
            INNER JOIN clients
                ON clients.id = cases.client_id
            WHERE CONCAT(
                hearings.hearing_date,
                " ",
                hearings.hearing_time
            ) >= NOW()
            ORDER BY
                hearings.hearing_date ASC,
                hearings.hearing_time ASC
            LIMIT :limit'
        );

        $statement->bindValue(':limit', $limit, PDO::PARAM_INT);

        $statement->execute();

        return $statement->fetchAll(PDO::FETCH_ASSOC);
    }


    public function getUpcomingHearingsForLawyer(
    int $lawyerId,
    int $limit = 5
    ): array {
        $statement = $this->pdo->prepare(
            'SELECT
                hearings.*,
                cases.case_number,
                clients.name AS client_name
            FROM hearings
            INNER JOIN cases
                ON cases.id = hearings.case_id
            INNER JOIN clients
                ON clients.id = cases.client_id
            WHERE cases.assigned_lawyer_id = :lawyer_id
            AND CONCAT(
                hearings.hearing_date,
                " ",
                hearings.hearing_time
            ) >= NOW()
            ORDER BY
                hearings.hearing_date ASC,
                hearings.hearing_time ASC
            LIMIT :limit'
        );

        $statement->bindValue(
            ':lawyer_id',
            $lawyerId,
            PDO::PARAM_INT
        );

        $statement->bindValue(
            ':limit',
            $limit,
            PDO::PARAM_INT
        );

        $statement->execute();

        return $statement->fetchAll(PDO::FETCH_ASSOC);
    }


}