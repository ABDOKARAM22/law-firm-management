<?php

namespace LawFirmManagement\Controllers;

use LawFirmManagement\Core\Auth;
use LawFirmManagement\Core\Csrf;
use LawFirmManagement\Core\Flash;
use LawFirmManagement\Core\ValidationException;
use LawFirmManagement\Repositories\UserRepository;
use LawFirmManagement\Services\AppointmentAccessService;
use LawFirmManagement\Services\AppointmentService;
use LawFirmManagement\Services\ClientService;

class AppointmentController
{
    
public function __construct(
    private AppointmentService $appointmentService,
    private ClientService $clientService,
    private UserRepository $userRepository,
    private AppointmentAccessService $appointmentAccessService,
    private Auth $auth
) {
}


    public function index(): void
    {
        $appointments = $this->appointmentAccessService->accessibleAppointments();

        require __DIR__ . '/../Views/appointments/index.php';
    }

    public function create(): void
    {
        $clients = $this->clientService->all();
        $users = $this->userRepository->allActiveUsers();

        $user = $this->auth->user();
        $role = $user['role'];

        require __DIR__ . '/../Views/appointments/create.php';
    }

    public function store(): void
    {
        if (!Csrf::verify($_POST['_token'] ?? null)) {
            http_response_code(419);
            echo 'Invalid CSRF token';
            return;
        }

        $clientId = $_POST['client_id'] ?? null;
        $assignedUserId = $_POST['assigned_user_id'] ?? '';
        $appointmentDate = $_POST['appointment_date'] ?? '';
        $appointmentTime = $_POST['appointment_time'] ?? '';
        $title = $_POST['title'] ?? '';
        $type = $_POST['type'] ?? '';
        $status = $_POST['status'] ?? 'scheduled';
        $notes = $_POST['notes'] ?? '';

        if ($clientId === '' || $clientId === null) {
            $clientId = null;
        } elseif (is_string($clientId)) {
            $clientId = trim($clientId);

            if ($clientId !== '') {
                $clientId = (int) $clientId;
            } else {
                $clientId = null;
            }
        }

        $values = [
            &$assignedUserId,
            &$appointmentDate,
            &$appointmentTime,
            &$title,
            &$type,
            &$status,
            &$notes,
        ];

        foreach ($values as &$value) {
            if (is_string($value)) {
                $value = trim($value);
            }
        }

        $user = $this->auth->user();

        $userId = (int) $user['id'];
        $role = $user['role'];

        /*
        * Lawyer can only assign the appointment to himself.
        */
        if ($role === 'lawyer') {
            $assignedUserId = $userId;
        }

        try {
            $this->appointmentService->create(
                $clientId,
                (int) $assignedUserId,
                $appointmentDate,
                $appointmentTime,
                $title,
                $type,
                $status,
                $notes
            );

            Flash::set(
                'success',
                'تم إضافة الموعد بنجاح.'
            );

            header('Location: ?route=appointments');
            exit;

        } catch (ValidationException $exception) {

            Flash::set(
                'errors',
                $exception->errors()
            );

            Flash::set('old', [
                'client_id' => $clientId,
                'assigned_user_id' => $assignedUserId,
                'appointment_date' => $appointmentDate,
                'appointment_time' => $appointmentTime,
                'title' => $title,
                'type' => $type,
                'status' => $status,
                'notes' => $notes,
            ]);

            header('Location: ?route=appointments/create');
            exit;
        }
    }


    public function edit(int $id): void
    {
        if (!$this->appointmentAccessService->canAccess($id)) {
            http_response_code(403);
            echo 'ليس لديك صلاحية للوصول إلى هذا الموعد.';
            return;
        }

        $appointment = $this->appointmentService->find($id);

        if ($appointment === false) {
            http_response_code(404);
            echo 'الموعد غير موجود.';
            return;
        }

        $clients = $this->clientService->all();

        $users = $this->userRepository->allActiveUsers();

        require __DIR__ . '/../Views/appointments/edit.php';
    }

}