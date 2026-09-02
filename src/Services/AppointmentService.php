<?php

namespace LawFirmManagement\Services;

use LawFirmManagement\Core\ValidationException;
use LawFirmManagement\Core\Validator;
use LawFirmManagement\Repositories\AppointmentRepository;
use LawFirmManagement\Repositories\ClientRepository;
use LawFirmManagement\Repositories\UserRepository;

class AppointmentService
{
    public function __construct(
        private AppointmentRepository $appointmentRepository,
        private ClientRepository $clientRepository,
        private UserRepository $userRepository
    ) {
    }

    public function all(): array
    {
        return $this->appointmentRepository->all();
    }

    public function create(
        mixed $clientId,
        mixed $assignedUserId,
        mixed $appointmentDate,
        mixed $appointmentTime,
        mixed $title,
        mixed $type,
        mixed $status,
        mixed $notes
    ): int {
        $validator = new Validator();

        /*
        * Client is optional.
        */
        if ($clientId !== null && $clientId !== '') {
            $validator
                ->integer('client_id', $clientId);
        }

        /*
        * Assigned user is required.
        */
        $validator
            ->required('assigned_user_id', $assignedUserId)
            ->integer('assigned_user_id', $assignedUserId);

        $validator
            ->required('appointment_date', $appointmentDate)
            ->string('appointment_date', $appointmentDate)

            ->required('appointment_time', $appointmentTime)
            ->string('appointment_time', $appointmentTime)

            ->required('title', $title)
            ->string('title', $title)

            ->required('type', $type)
            ->string('type', $type)

            ->in('status', $status, [
                'scheduled',
                'completed',
                'cancelled',
            ])

            ->string('notes', $notes);

        if ($validator->fails()) {
            throw new ValidationException(
                $validator->errors()
            );
        }

        /*
        * Convert validated IDs to integers.
        */
        if ($clientId !== null && $clientId !== '') {
            $clientId = (int) $clientId;
        } else {
            $clientId = null;
        }

        $assignedUserId = (int) $assignedUserId;

        /*
        * Verify client exists.
        */
        if ($clientId !== null) {
            $client = $this->clientRepository->findById($clientId);

            if ($client === false) {
                throw new ValidationException([
                    'client_id' => 'العميل غير موجود.',
                ]);
            }
        }

        /*
        * Verify assigned user exists.
        */
        $user = $this->userRepository->findById($assignedUserId);

        if ($user === false) {
            throw new ValidationException([
                'assigned_user_id' => 'المستخدم المسؤول غير موجود.',
            ]);
        }

        /*
        * Only active lawyers/staff can be assigned appointments.
        */
        if (
            $user['status'] !== 'active' ||
            !in_array($user['role'], ['lawyer', 'staff'], true)
        ) {
            throw new ValidationException([
                'assigned_user_id' =>
                    'المستخدم المحدد غير صالح لتعيين الموعد.',
            ]);
        }

        return $this->appointmentRepository->create(
            $clientId,
            $assignedUserId,
            $appointmentDate,
            $appointmentTime,
            $title,
            $type,
            $status,
            $notes
        );
    }
}
