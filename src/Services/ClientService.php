<?php

namespace LawFirmManagement\Services;

use LawFirmManagement\Core\ValidationException;
use LawFirmManagement\Core\Validator;
use LawFirmManagement\Repositories\ClientRepository;

class ClientService
{
    public function __construct(
        private ClientRepository $clientRepository
    ) {
    }

    public function all(): array
    {
        return $this->clientRepository->all();
    }

    public function find(int $id): array|false
    {
        return $this->clientRepository->findById($id);
    }

    public function create(
        mixed $name,
        mixed $nationalId,
        mixed $phone,
        mixed $email,
        mixed $address,
        mixed $status
    ): void {
        $validator = new Validator();

        $validator
            ->required('name', $name)
            ->string('name', $name)
            ->alpha('name', $name)

            ->required('national_id', $nationalId)
            ->string('national_id', $nationalId)
            ->numericLength('national_id', $nationalId, 14)
            
            ->required('phone', $phone)
            ->string('phone', $phone)
            ->egyptianPhone('phone', $phone)

            ->string('email', $email)
            ->email('email', $email)

            ->string('address', $address)

            ->required('status', $status)
            ->in('status', $status, [
                'active',
                'inactive',
            ]);

        if ($validator->fails()) {
            throw new ValidationException(
                $validator->errors()
            );
        }
        
        
        if (
            $this->clientRepository->existsByNationalId(
                $nationalId
            )
        ) {
            throw new ValidationException([
                'national_id' =>
                    'الرقم القومي مستخدم بالفعل.'
            ]);
        }


        if (
            $email !== '' &&
            $this->clientRepository->existsByEmail($email)
        ) {
            throw new ValidationException([
                'email' => 'البريد الإلكتروني مستخدم بالفعل.'
            ]);
        }


        $this->clientRepository->create(
            $name,
            $nationalId,
            $phone,
            $email ?: null,
            $address ?: null,
            $status
        );
    }
}